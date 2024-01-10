<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once __DIR__ . "/../inc/dompdf/autoload.inc.php";

use Dompdf\Dompdf;
use Dompdf\Options;

class ServicePetsconfigurator extends WP_REST_Controller
{
    public function register_routes()
    {
        $namespace = 'esthima/v1';

        register_rest_route($namespace, '/urnes', array(
            'methods' => 'GET',
            'callback' => array($this, 'getUrnes')
        ));
        register_rest_route($namespace, '/register-devis', array(
            'methods' => 'POST',
            'callback' => array($this, 'registerDevis')
        ));
        register_rest_route($namespace, '/generate-pdf', array(
            'methods' => 'GET',
            'callback' => array($this, 'generatePDF')
        ));
    }

    public function getUrnes(WP_REST_Request $request)
    {

        $urnes = wc_get_products([
            'status' => 'publish',
            'limit' => -1,
            'category' => [
                'urnes-chien',
                'urnes-chat',
                'urnes-nac'
            ]
        ]);

        $urnesR = [];
        foreach ($urnes as $u) {
            $currentUrne = [];
            $currentUrne['type'] = $u->get_type();
            if ($currentUrne['type'] == 'variable') {
                $currentUrne['sku'] = $u->sku;
                $currentUrne['price'] = $u->get_variation_regular_price();
                $currentUrne['name'] = $u->name;
                $currentUrne['stock_status'] = $u->stock_status;
                $currentUrne['description'] = $u->description;
                $currentUrne['variations_prices'] = $u->get_variation_prices();
                $currentUrne['variations'] = $u->get_variation_attributes();
                $currentUrne['available'] = true;
                $currentUrne['available_variations'] = $u->get_available_variations();
                $currentUrne['image'] = $u->get_image();
                $currentUrne['image_url'] = wp_get_attachment_image_url($u->get_image_id(), 'medium');
            } else {
                $currentUrne['sku'] = $u->sku;
                $currentUrne['price'] = $u->price;
                $currentUrne['name'] = $u->name;
                $currentUrne['available'] = true;
                $currentUrne['stock_status'] = $u->stock_status;
                $currentUrne['description'] = $u->description;
                $currentUrne['image'] = $u->get_image();
                $currentUrne['image_url'] = wp_get_attachment_image_url($u->get_image_id(), 'medium');
              
            }

            $urnesR[] = $currentUrne;
        }


        return new WP_REST_Response($urnesR, 200);
    }
    

    public function registerDevis(WP_REST_Request $request)
    {
        global $wpdb;

        $espece = $request->get_param('espece');
        $nom = $request->get_param('nom');
        $recuperation_cendres = $request->get_param('recuperation_cendres');
        $ceremonie_adieu = $request->get_param('ceremonie_adieu');
        $urne = $request->get_param('urne');
        $urne_sku = $request->get_param('urne_sku');
        $geste_souvenir = $request->get_param('geste_souvenir');
        $cremation = $request->get_param('cremation');
        $prix_urne = $request->get_param('prix_urne');
        $prix_geste_souvenir = $request->get_param('prix_geste_souvenir');
        $prix_cremation = $request->get_param('prix_cremation');
        $prix_total = $request->get_param('prix_total');
        $email = $request->get_param('email');
        $nom_personne = $request->get_param('nom_personne');
        $prenom_personne = $request->get_param('prenom_personne');
        $compte = $request->get_param('userID');
        $postTitle = $espece . ' - ' . $nom . ' - ' . $email;

        $name = sanitize_title($postTitle);
        $postIDExist = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_type = 'post' AND post_status = 'publish'", $name ) );

        if ($postIDExist) {
            $post_id = $postIDExist;
        } else {

            $post_id = wp_insert_post(array(
                'post_title'    => $postTitle,
                'post_content' => '',
                'post_status'   => 'publish',
                'post_author'   => 1,
                'post_type'     => 'devis'
            ));

            if($post_id) {
                update_field('espece', $espece, $post_id);
                update_field('nom', $nom, $post_id);
                update_field('recuperation_cendres', $recuperation_cendres, $post_id);
                update_field('ceremonie_adieu', $ceremonie_adieu, $post_id);
                update_field('urne', $urne, $post_id);
                // if (!empty($urne_relation)) {
                //     update_field('compte', $urne_relation, $post_id);
                // }
                update_field('urne_sku', $urne_sku, $post_id);
                update_field('geste_souvenir', $geste_souvenir, $post_id);
                update_field('cremation', $cremation, $post_id);
                update_field('prix_urne', $prix_urne, $post_id);
                update_field('prix_geste_souvenir', $prix_geste_souvenir, $post_id);
                update_field('prix_cremation', $prix_cremation, $post_id);
                update_field('prix_total', $prix_total, $post_id);
                if (!empty($compte)) {
                    update_field('compte', $compte, $post_id);
                } else {
                    $users = get_users(array('search' => $email, 'search_columns' => array('user_login')));
                    if ($users) {
                        update_field('compte', $users[0]->ID, $post_id);
                    }
                }
                update_field('email', $email, $post_id);
                update_field('nom_personne', $nom_personne, $post_id);
                update_field('prenom_personne', $prenom_personne, $post_id);
            }
        }


        return $post_id;
    }

    public function generatePDF(WP_REST_Request $request) {

        $post_id = $request->get_param('id');

        $espece = get_field('espece', $post_id);
        $nom = get_field('nom', $post_id);
        $recuperation_cendres = get_field('recuperation_cendres', $post_id);
        $ceremonie_adieu = get_field('ceremonie_adieu', $post_id);
        $urne = get_field('urne', $post_id);
        $urne_sku = get_field('urne_sku', $post_id);
        $geste_souvenir = get_field('geste_souvenir', $post_id);
        $cremation = get_field('cremation', $post_id);
        $prix_urne = get_field('prix_urne', $post_id);
        $prix_geste_souvenir = get_field('prix_geste_souvenir', $post_id);
        $prix_cremation = get_field('prix_cremation', $post_id);
        $prix_total = get_field('prix_total', $post_id);
        $email = get_field('email', $post_id);
        $nom_personne = get_field('nom_personne', $post_id);
        $prenom_personne = get_field('prenom_personne', $post_id);
        $compte = get_field('userID', $post_id);
        $postTitle = $espece . ' - ' . $nom . ' - ' . $email;
       

        ob_start();
        echo get_template_part('templates/devis-pdf', null, [
            'espece' => $espece,
            'nom' => $nom,
            'recuperation_cendres' => $recuperation_cendres,
            'ceremonie_adieu' => $ceremonie_adieu,
            'urne' => $urne,
            'urne_sku' => $urne_sku,
            'geste_souvenir' => $geste_souvenir,
            'cremation' => $cremation,
            'prix_urne' => $prix_urne,
            'prix_geste_souvenir' => $prix_geste_souvenir,
            'prix_cremation' => $prix_cremation,
            'prix_total' => $prix_total,
            'nom_personne' => $nom_personne,
            'prenom_personne' => $prenom_personne,
            'prix_geste_souvenir' => $prix_geste_souvenir,
            'email' => $email,
            'compte' => $compte,
            'postTitle' => $postTitle
        ]);
    
        $devis = ob_get_clean();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $pdf = new Dompdf($options);
        $pdf->loadHtml($devis);
        $pdf->render();
        $pdf->stream('devis.pdf', ['Attachements' => 0]);
    }
    
}
add_action('rest_api_init', function () {
    (new ServicePetsconfigurator())->register_routes();
});