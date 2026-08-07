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

$_wp_user    = wp_get_current_user();
$_is_logged  = is_user_logged_in();

$esthima_user = [
    'isLoggedIn'   => $_is_logged,
    'id'           => $_is_logged ? (int) $_wp_user->ID            : null,
    'login'        => $_is_logged ? $_wp_user->user_login          : null,
    'email'        => $_is_logged ? $_wp_user->user_email          : null,
    'firstName'    => $_is_logged ? $_wp_user->first_name          : null,
    'lastName'     => $_is_logged ? $_wp_user->last_name           : null,
    'roles'        => $_is_logged ? array_values( $_wp_user->roles ) : [],
    'isSsoManaged' => $_is_logged ? (bool)   get_user_meta( $_wp_user->ID, '_sso_jwt_managed',   true ) : false,
    'jwt'          => $_COOKIE['jwt_token'] ?? null,
];

// Traiter le formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$animal_name = sanitize_text_field($_POST['animal_name'] ?? '');
	$animal_species = sanitize_text_field($_POST['animal_species'] ?? '');
	$tracking_id = sanitize_text_field($_POST['tracking_number'] ?? '');

	// ✅ NORMALISATION INC : accepte inc/INC/inC + accepte 8 chiffres seuls
	$tracking_id = strtoupper(trim($tracking_id));
	$tracking_id = preg_replace('/[^A-Z0-9]/', '', $tracking_id);
	if (preg_match('/^\d{8}$/', $tracking_id)) {
		$tracking_id = 'INC' . $tracking_id;
	}

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

				// Définir les 4 étapes principales à afficher
				$main_steps = [
					'creation' => [
						'name' => 'Demande de prise en charge funéraire créée',
						'description' => "Nous avons bien enregistré votre demande de crémation. Si le corps de votre animal se trouve actuellement en clinique, il sera pris en charge très prochainement par nos agents.",
						'order' => 0
					],
					'arrived' => [
						'name' => 'Arrivée au crématorium',
						'description' => "Votre animal est bien arrivé sur notre crématorium animalier",
						'order' => 1
					],
					'cremation_end' => [
						'name' => 'Crémation réalisée',
						'description' => "La crémation de votre animal a eu lieu. En cas de restitution des cendres, nos équipes apportent le plus grand soin à la préparation de l’urne funéraire.",
						'order' => 2
					],
					'urn_preparation' => [
						'name' => "Préparation de l'urne",
						'description' => "Les cendres de votre animal ont été délicatement placées dans une urne de dispersion ou décorative. Selon le mode de restitution choisi, le crématorium ou la clinique vétérinaire vous informera dès que l’urne funéraire sera disponible.",
						'order' => 3
					]
				];

				// Initialiser toutes les étapes principales avec le statut 'pending'
				$standard_steps = [];
				foreach ($main_steps as $step_key => $step_data) {
					$standard_steps[$step_key] = $step_data;
					$standard_steps[$step_key]['status'] = 'pending';
					$standard_steps[$step_key]['date'] = '';
				}

				// Collecter les dates des étapes qui existent dans les données API
				$task_dates = [];
				foreach ($data['tasks'] as $task) {
					if (!is_array($task) || empty($task['name']) || is_numeric($task['name'])) continue;

					$step_name = $task['name'];

					// Si cette étape fait partie de nos 4 étapes principales
					if (isset($standard_steps[$step_name]) && !empty($task['at'])) {
						$standard_steps[$step_name]['date'] = date('d/m/Y', strtotime($task['at']));
						$task_dates[$step_name] = strtotime($task['at']);
					}
				}

				// Déterminer le statut de chaque étape
				$step_keys = array_keys($standard_steps);
				$last_completed_index = -1;

				// Trouver la dernière étape avec une date
				for ($i = count($step_keys) - 1; $i >= 0; $i--) {
					$step_key = $step_keys[$i];
					if (!empty($standard_steps[$step_key]['date'])) {
						$last_completed_index = $i;
						break;
					}
				}

				// Assigner les statuts
				foreach ($step_keys as $index => $step_key) {
					if ($index < $last_completed_index) {
						$standard_steps[$step_key]['status'] = 'completed';
					} elseif ($index === $last_completed_index) {
						$standard_steps[$step_key]['status'] = 'active';
					} else {
						$standard_steps[$step_key]['status'] = 'pending';
					}
				}

				// Utiliser la description unique pour chaque étape
				foreach ($standard_steps as $key => $step) {
					// La description est déjà définie dans $main_steps, pas besoin de la sélectionner en fonction du statut
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

<script>
    window.EsthimaUser = <?php echo wp_json_encode( $esthima_user ); ?>;
</script>

<main class="main main-content main-content--alt">
	<div class="wrap wrap--lg">
		<div class="tracking-box">
			<div class="yoast-breadcrumbs">
				<?php if (function_exists("yoast_breadcrumb")) {
					yoast_breadcrumb();
				} ?>
			</div>
			<h1 class="page-header__title">Mon espace</h1>

            <div id="root"></div>

            <div style="position:fixed;bottom:20px;right:20px;z-index:99999;background:#0f172a;color:#e2e8f0;font:13px/1.7 monospace;padding:14px 18px;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.5);min-width:260px">
                <div style="font-size:11px;text-transform:uppercase;letter-spacing:.08em;color:#64748b;margin-bottom:8px">SSO Debug</div>

                <?php if ( $esthima_user['isLoggedIn'] ) : ?>
                    <div style="color:#4ade80;font-weight:bold;margin-bottom:8px">✓ Connecté</div>
                    <table style="border-collapse:collapse;width:100%;font-size:13px">
                        <tr><td style="color:#64748b;padding-right:12px">ID</td><td><?php echo esc_html( $esthima_user['id'] ); ?></td></tr>
                        <tr><td style="color:#64748b">Login</td><td><?php echo esc_html( $esthima_user['login'] ); ?></td></tr>
                        <tr><td style="color:#64748b">Email</td><td><?php echo esc_html( $esthima_user['email'] ); ?></td></tr>
                        <tr><td style="color:#64748b">Prénom</td><td><?php echo esc_html( $esthima_user['firstName'] ); ?></td></tr>
                        <tr><td style="color:#64748b">Nom</td><td><?php echo esc_html( $esthima_user['lastName'] ); ?></td></tr>
                        <tr><td style="color:#64748b">Rôle</td><td><?php echo esc_html( implode( ', ', $esthima_user['roles'] ) ); ?></td></tr>
                        <tr><td style="color:#64748b">Compte SSO</td><td><?php echo $esthima_user['isSsoManaged'] ? '<span style="color:#4ade80">oui</span>' : '<span style="color:#94a3b8">non (natif)</span>'; ?></td></tr>
                    </table>
                <?php else : ?>
                    <div style="color:#f87171;font-weight:bold;margin-bottom:8px">✗ Non connecté</div>
                <?php endif; ?>

                <div style="margin-top:10px;padding-top:10px;border-top:1px solid #1e293b;color:#64748b;font-size:12px">
                    Cookie <code style="color:#e2e8f0">jwt_token</code> :
                    <?php echo $esthima_user['jwt'] ? '<span style="color:#4ade80">présent</span>' : '<span style="color:#f87171">absent</span>'; ?>
                </div>
            </div>

			<?php if (!$isLoggedIn) { ?>
				<p>Pour être informé du parcours funéraire de votre animal, veuillez renseigner les champs ci-dessous.</p>
			<?php } ?>
			<div class="tracking-container">
					<?php if (!$isLoggedIn) { ?>
						<!-- Formulaire de recherche -->
						<form action="" method="post" class="tracking-search-form">
							<div class="form-group">
								<label for="tracking_number">
									Numéro de suivi (INC)
									<span class="help-icon" data-tooltip="Où trouver le n° de suivi INC ? Vous pouvez retrouver le numéro de suivi (INC+8 chiffres) en haut à droite de la convention">?</span>
								</label>
								<input type="text" id="tracking_number" name="tracking_number" placeholder="INC12345678" value="<?php echo esc_attr($tracking_id); ?>">
							</div>
							<div class="form-group">
								<label for="animal_name">Nom de l'animal</label>
								<input type="text" id="animal_name" name="animal_name" placeholder="Nom de l'animal" value="<?php echo esc_attr($animal_name); ?>">
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

								<h3 class="tracking-title">Parcours funéraire de <?php echo esc_html($animal_name); ?></h3>

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
						<?php
						// Trouver l'étape active
						$active_step_data = null;
						foreach ($tracking_steps as $step) {
							if ($step['status'] === 'active') {
								$active_step_data = $step;
								break;
							}
						}
						?>
						<?php if (!empty($active_step_data)) : ?>
							<div class="tracking-step dynamic-content">
								<h4 class="step-title">
									Étape <?php echo esc_html($active_step_data['order'] + 1); ?> : <?php echo esc_html($active_step_data['name']); ?>
									<span class="step-date"><?php echo esc_html($active_step_data['date']); ?></span>
								</h4>
								<p class="step-description">
									<?php echo esc_html($active_step_data['description']); ?>
								</p>
							</div>
						<?php endif; ?>
					<?php } ?>
			</div>

			<div class="tracking-container tracking-container--contact">
				<img src="<?php echo get_template_directory_uri(); ?>/images/envelope.svg" alt="Téléphone" class="tracking__contact-picto">
				<p class="tracking__contact-text">Si besoin, veuillez
					contacter notre service client via le formulaire en cliquant sur le bouton ci-dessous</p>
				<a href="<?php echo home_url(); ?>/contact" target="_blank" class="btn btn--arrow tracking__contact-btn">
					Nous contacter
				</a>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>
