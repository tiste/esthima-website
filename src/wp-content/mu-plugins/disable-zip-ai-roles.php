<?php
/**
 * Désactive la boucle d'écriture des rôles utilisateurs par Zip AI (Spectra/UAG).
 * Fix pour : est_user_roles réécrit à chaque admin_init.
 */
add_filter( 'zip_ai_assistant_capability_additional_roles', '__return_empty_array' );
