<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace nagestao\utilitarios;

/**
 * Description of UtilsForm
 *
 * @author breno.mayder
 */
class UtilsForm {
    
    static function formInput() {
        $campo = '<div class="form-group m-form__group row">
                    <div class="col-lg-6">
                        <label>Full Name:</label>
                        <input type="email" class="form-control m-input" placeholder="Enter full name">
                        <span class="m-form__help">Please enter your full name</span>
                    </div>
                </div>';
        return $campo;
    }

}
