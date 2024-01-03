<?php if (!defined('ABSPATH')) exit; // Exit if accessed directly
/**
 * Exemple de service REST de WP.
 * Le service pourra être appelé comme ceci: `http://{hote}/wp-json/{API_SITE_DOMAINE}/v{API_SITE_VERSION}/{route}`
 */
class ServicePetsconfigurator extends WP_REST_Controller
{
    public function register_routes()
    {
        $namespace = 'esthima/v1';

        register_rest_route($namespace, '/urnes', array(
            'methods' => 'GET',
            'callback' => array($this, 'getUrnes')
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
                $currentUrne['description'] = $u->description;
                $currentUrne['variations_prices'] = $u->get_variation_prices();
                $currentUrne['variations'] = $u->get_variation_attributes();
                $currentUrne['available_variations'] = $u->get_available_variations();
                $currentUrne['image'] = $u->get_image();
                $currentUrne['image_url'] = wp_get_attachment_image_url($u->get_image_id(), 'medium');
            } else {
                $currentUrne['sku'] = $u->sku;
                $currentUrne['price'] = $u->price;
                $currentUrne['name'] = $u->name;
                $currentUrne['description'] = $u->description;
                $currentUrne['image'] = $u->get_image();
                $currentUrne['image_url'] = wp_get_attachment_image_url($u->get_image_id(), 'medium');
              
            }

            $urnesR[] = $currentUrne;
        }


        return new WP_REST_Response($urnesR, 200);
    }
}
add_action('rest_api_init', function () {
    (new ServicePetsconfigurator())->register_routes();
});