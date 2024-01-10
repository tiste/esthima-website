<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<form action="#" class="rappel">
    <div class="rappel__grid">
        <div class="rappel__half">
            <select name="gender" id="gender">
                <option value="Mr">Mr</option>
                <option value="Mme">Mme</option>
            </select>
        </div>
        <div class="rappel__empty"></div>
        <div class="rappel__half has-label">
            <label for="lastname">Nom*</label>
            <input type="text" name="lastname" id="lastname">
        </div>
        <div class="rappel__half has-label">
            <label for="firstname">Prénom*</label>
            <input type="text" name="firstname" id="firstname">
        </div>
        <div class="rappel__full has-label">
            <label for="tel">Téléphone*</label>
            <input type="tel" name="tel" id="tel">
        </div>
    </div>
    <input type="submit" value="Être rappelé">
</form>
<div>* Champs obligatoires</div>