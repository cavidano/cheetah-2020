<?php

class nsc_bar_admin_error
{
    public $errors;

    public function __construct()
    {
        $this->errors = array();
    }

    public function nsc_bar_display_errors()
    {
        if (!empty($this->errors)) {
            add_action('admin_notices', array($this, 'nsc_bar_add_admin_errors'));
        }
    }

    public function nsc_bar_set_admin_error($error, $type = "error")
    {
        $this->errors[$type][] = $error;
    }

    public function nsc_bar_add_admin_errors()
    {
        foreach ($this->errors as $error_type => $type) {
            foreach ($type as $error_message) {
                echo '<div class="notice notice-error">
                       <p>' . __($error_message, "nsc_bar_cookie_consent") . '</p>
                    </div>';
            }
        }
    }

}
