<?php
if (!defined('ABSPATH')) exit; // Exit if accessed directly

/*
* Template Name: Tracking
*/

get_header();

$isLoggedIn = false;
$tracking_steps = [];
$active_step = 0;
$animal_name = '';
$animal_species = '';
$tracking_id = '';
$api_error = '';
$success_message = '';
$payment_info = [
	'method' => 'credit_card',
	'status' => 'pending'
];

require_once get_template_directory() . '/inc/api_helpers.php';

// Traiter le formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$animal_name = sanitize_text_field($_POST['animal_name'] ?? '');
	$animal_species = sanitize_text_field($_POST['animal_species'] ?? '');
	$tracking_id = sanitize_text_field($_POST['tracking_number'] ?? '');

	$missing_fields = [];

	if (empty($tracking_id)) $missing_fields[] = "le numéro de suivi";
	if (empty($animal_name)) $missing_fields[] = "le nom de l'animal";
	if (empty($animal_species)) $missing_fields[] = "l'espèce de l'animal";

	if (!empty($missing_fields)) {
		$api_error = "Veuillez renseigner " . implode(", ", $missing_fields) . ".";
	} elseif (!preg_match('/^INC\d{8}$/', $tracking_id)) {
		$api_error = "Veuillez renseigner INC et ensuite 8 chiffres";
	} else {
		$result = esthima_get_tracking($tracking_id, $animal_name, $animal_species);

		if (!empty($result['error'])) {
			$api_error = $result['error'];
		} else {
			$data = $result['data'];

			if (!empty($data['tasks']) && is_array($data['tasks'])) {
				$isLoggedIn = true;
				$success_message = "Le suivi de <strong>" . esc_html($animal_name) . "</strong> a été retrouvé avec succès.";

				if (!empty($data['paymentMethod'])) {
					$payment_info['method'] = $data['paymentMethod'];
				}
				if (!empty($data['paymentStatus'])) {
					$payment_info['status'] = $data['paymentStatus'];
				}

				// On trouve d'abord la dernière tâche avec une date remplie
				$last_filled_task_index = -1;
				foreach ($data['tasks'] as $index => $task) {
					if (is_array($task) && !empty($task['at'])) {
						$last_filled_task_index = $index;
					}
				}

				// Définir les 4 étapes standard
				$standard_steps = [
					'creation' => [
						'name' => 'Création',
						'description_pending' => "Votre animal [nom_animal] sera pris en charge par nos équipes très prochainement.",
						'description_active' => "Votre animal [nom_animal] est actuellement pris en charge par nos équipes.",
						'description_completed' => "Votre animal [nom_animal] a été pris en charge par nos équipes.",
						'status' => 'pending',
						'date' => '',
						'order' => 0
					],
					'arrived' => [
						'name' => 'Arrivée',
						'description_pending' => "Votre animal [nom_animal] arrivera prochainement dans notre établissement.",
						'description_active' => "Votre animal [nom_animal] vient d'arriver dans notre établissement.",
						'description_completed' => "Votre animal [nom_animal] est arrivé dans notre établissement.",
						'status' => 'pending',
						'date' => '',
						'order' => 1
					],
					'processing' => [
						'name' => 'Traitement',
						'description_pending' => "Votre animal [nom_animal] sera bientôt traité par nos équipes.",
						'description_active' => "Votre animal [nom_animal] est actuellement en cours de traitement.",
						'description_completed' => "Votre animal [nom_animal] a été traité par nos équipes.",
						'status' => 'pending',
						'date' => '',
						'order' => 2
					],
					'cremation' => [
						'name' => 'Crémation',
						'description_pending' => "La crémation de [nom_animal] aura lieu très prochainement.",
						'description_active' => "La crémation de [nom_animal] est actuellement en cours.",
						'description_completed' => "La crémation de [nom_animal] a été effectuée avec soin.",
						'status' => 'pending',
						'date' => '',
						'order' => 3
					]
				];

				// Remplir les étapes avec les données de l'API si elles existent
				foreach ($data['tasks'] as $index => $task) {
					if (!is_array($task) || empty($task['name']) || !isset($standard_steps[$task['name']])) continue;

					$step_key = $task['name'];

					if (!empty($task['at'])) {
						$standard_steps[$step_key]['date'] = date('d/m/Y', strtotime($task['at']));
						$standard_steps[$step_key]['status'] = ($index === $last_filled_task_index) ? 'active' : 'completed';

						// Si c'est la dernière tâche remplie, on la définit comme active
						if ($index === $last_filled_task_index) {
							$active_step = $standard_steps[$step_key]['order'];
						}
					}
				}

				// Sélectionner la description appropriée en fonction du statut et injecter le nom de l'animal
				foreach ($standard_steps as $key => $step) {
					$description_key = 'description_' . $step['status'];
					$standard_steps[$key]['description'] = str_replace('[nom_animal]', $animal_name, $step[$description_key]);
				}

				// Convertir le tableau associatif en tableau indexé pour l'affichage
				$tracking_steps = array_values($standard_steps);

				if (empty($data['tasks'])) {
					$api_error = "Aucune étape de parcours trouvée pour cet animal.";
					$isLoggedIn = false;
				}
			} else {
				$api_error = "Ces données ne correspondent pas. Vérifiez les informations saisies. Si le problème persiste, merci de vous rapprocher de notre service client pour plus d'informations sur la crémation de votre animal";
			}
		}
	}
}
?>

<main class="main main-content main-content--alt">
	<div class="wrap wrap--lg">
		<div class="tracking-box">
			<div class="yoast-breadcrumbs">
				<?php if (function_exists("yoast_breadcrumb")) {
					yoast_breadcrumb();
				} ?>
			</div>
			<h1 class="page-header__title">Parcours funéraire</h1>
			<div class="tracking-container">
					<?php if (!$isLoggedIn) { ?>
						<!-- Formulaire de recherche -->
						<form action="" method="post" class="tracking-search-form">
							<div class="form-group">
								<label for="tracking_number">
									Numéro de suivi (INC)
									<span class="help-icon" data-tooltip="Où trouver mon INC ? Vous pouvez trouver votre INC en haut à droite de la convention de crémation de votre animal">?</span>
								</label>
								<input type="text" id="tracking_number" name="tracking_number" value="<?php echo esc_attr($tracking_id); ?>">
							</div>
							<div class="form-group">
								<label for="animal_name">Nom de l'animal</label>
								<input type="text" id="animal_name" name="animal_name" value="<?php echo esc_attr($animal_name); ?>">
							</div>
							<div class="form-group">
								<label for="animal_species">Espèce de l'animal</label>
								<div class="select-wrapper">
									<select id="animal_species" name="animal_species">
										<option value="CAT" <?php selected($animal_species, 'CAT'); ?>>Chat</option>
										<option value="DOG" <?php selected($animal_species, 'DOG'); ?>>Chien</option>
										<option value="649" <?php selected($animal_species, '649'); ?>>Nouveaux Animaux de Compagnie</option>
									</select>
								</div>
							</div>
							<?php if (!empty($api_error)) : ?>
								<div class="error-message"><?php echo esc_html($api_error); ?></div>
							<?php endif; ?>
							<button type="submit" class="btn btn--arrow submit-tracking-btn">Valider</button>
						</form>
					<?php } else { ?>
						<!-- Résultat de suivi - s'affiche après soumission du formulaire -->
						<div class="tracking-result">
							<?php
							$offerTypeLabel = '';
							if (isset($data['offerType'])) {
								switch ($data['offerType']) {
									case 'plural':
										$offerTypeLabel = 'crémation plurielle';
										break;
									case 'reference':
										$offerTypeLabel = 'crémation référence';
										break;
									case 'private':
										$offerTypeLabel = 'service funéraire avec crémation privée';
										break;
									default:
										$offerTypeLabel = $data['offerType'];
								}
							}

							// Vérifier si toutes les dates sont vides
							$has_any_date = false;
							foreach ($tracking_steps as $step) {
								if (!empty($step['date'])) {
									$has_any_date = true;
									break;
								}
							}
							?>

							<?php if ($has_any_date) : ?>

								<h3 class="tracking-title">Parcours funéraire <?php echo $offerTypeLabel ? '(' . esc_html($offerTypeLabel) . ')' : ''; ?> <?php echo esc_html($animal_name); ?></h3>

								<!-- Timeline avec les étapes et tooltips intégrés -->
								<div class="tracking-timeline">
									<div class="timeline">
										<?php foreach ($tracking_steps as $index => $step) : ?>
											<div class="timeline-point <?php echo esc_attr($step['status']); ?>" data-step-index="<?php echo esc_attr($index); ?>">
											</div>
										<?php endforeach; ?>
									</div>

									<!-- Tooltips séparés, positionnés par JavaScript -->
									<?php foreach ($tracking_steps as $index => $step) : ?>
										<div class="timeline-tooltip" id="tooltip-<?php echo esc_attr($index); ?>">
											<div class="timeline-tooltip-header">
												<span class="step-title"><?php echo esc_html($step['name']); ?></span>
												<?php if (!empty($step['date'])) : ?>
													<span class="step-date"><?php echo esc_html($step['date']); ?></span>
												<?php endif; ?>
											</div>
											<div class="timeline-tooltip-body">
												<?php echo esc_html($step['description']); ?>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							<?php else : ?>
								<!-- Message si aucunes dates -->
								<div class="tracking-message">
									<p>Le parcours funéraire n'a pas encore commencé. Vous serez informé dès que la première étape sera validée.</p>
								</div>
							<?php endif; ?>
						</div>

						<!-- Affichage détaillé de l'étape active -->
						<?php if (!empty($tracking_steps) && isset($tracking_steps[$active_step])) : ?>
							<div class="tracking-step dynamic-content">
								<h4 class="step-title">
									Étape : <?php echo esc_html($tracking_steps[$active_step]['name']); ?>
									<span class="step-date"><?php echo esc_html($tracking_steps[$active_step]['date']); ?></span>
								</h4>
								<p class="step-description">
									<?php echo esc_html($tracking_steps[$active_step]['description']); ?>
								</p>
							</div>
						<?php endif; ?>

						<!-- Affichage du bouton de paiement -->
						<?php if ($payment_info['method'] === 'credit_card' && $payment_info['status'] === 'in_progress') : ?>
							<div class="payment-section">
								<p class="payment-text">Si le
									règlement n’a pas encore été réalisé, nous vous invitons à le faire
									directement depuis cette page en cliquant sur le bouton ci-dessous</p>
								<a href="<?php echo PAYMENT_URL . $tracking_id; ?>" target="_blank" class="btn btn--arrow">
									Payer ici
								</a>
							</div>
						<?php endif; ?>
					<?php } ?>
			</div>

			<div class="tracking-container">
				<img src="<?php echo get_template_directory_uri(); ?>/images/phone.svg" alt="Téléphone" class="tracking__contact-picto">
				<p class="tracking__contact-text">Si besoin, veuillez
					contacter notre service client via le formulaire en cliquant sur le bouton
					ci-dessous ou en appelant via le numéro suivant : <a href="tel:0805622222" class="tracking__contact-phone">0 805 622 222</a></p>
				<a href="<?php echo home_url(); ?>/contact" target="_blank" class="btn btn--arrow tracking__contact-btn">
					Nous contacter
				</a>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>