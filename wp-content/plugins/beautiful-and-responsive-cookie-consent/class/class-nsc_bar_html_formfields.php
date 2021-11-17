<?php

class nsc_bar_html_formfields
{
    private $field;
    private $prefix;

    public function nsc_bar_return_form_field($field, $prefix)
    {
        $this->field = $field;
        $this->prefix = $prefix;
        switch ($this->field->type) {
            case "checkbox":
                return $this->create_checkbox();
                break;
            case "textarea":
                return $this->create_textarea();
                break;
            case "text":
                return $this->create_text();
                break;
            case "longtext":
                return $this->create_text("long");
                break;
            case "select":
                return $this->create_select();
                break;
            case "radio":
                return $this->create_radio();
                break;
            case "hidden":
                return $this->create_hidden_field();
                break;
            default:
                return $this->field->pre_selected_value;
                break;
        }
    }

    public function nsc_bar_get_language_dropdown()
    {
        if (class_exists("nsc_bara_html_formfields_addon") === true) {
            $form_fields_addon = new nsc_bara_html_formfields_addon();
            return $form_fields_addon->nsc_bara_get_language_dropdown();
        }
        return '<select name="nsc_bar_language_selector" id="nsc_bar_countries_select"><option value="xx">Default</option></select>';
    }

    private function create_checkbox()
    {
        $checkbox = '<input ' . $this->nsc_bar_is_disabled($this->field) . ' id="ff_' . $this->prefix . $this->field->field_slug . '" type="checkbox" name="' . $this->prefix . $this->field->field_slug . '" id="' . $this->prefix . $this->field->field_slug . '" value="1" ' . checked(1, $this->field->pre_selected_value, false) . '>';
        if (empty($this->nsc_bar_is_disabled($this->field)) === true) {
            $checkbox = '<input type="hidden" name="' . $this->prefix . $this->field->field_slug . '_hidden" value="0"/>' . $checkbox;
        }
        return '<label>' . $checkbox . '</label>';
    }

    private function create_textarea()
    {
        return '<label><textarea ' . $this->nsc_bar_is_disabled($this->field) . '  id="ff_' . $this->prefix . $this->field->field_slug . '" cols="120"  id="' . $this->prefix . $this->field->field_slug . '" name="' . $this->prefix . $this->field->field_slug . '" rows="20" class="large-text code" type="textarea">' . $this->convert_to_string($this->field->pre_selected_value) . '</textarea></label>';
    }

    private function create_hidden_field()
    {
        return "<input type='hidden'  id='ff_" . $this->prefix . $this->field->field_slug . "' name='" . $this->prefix . $this->field->field_slug . "_hidden' value='" . $this->convert_to_string($this->field->pre_selected_value) . "'/>";
    }

    private function create_text($length = "short")
    {
        $size = 20;
        if ($length == "long") {
            $size = 50;
        }
        return '<label><input ' . $this->nsc_bar_is_disabled($this->field) . ' id="ff_' . $this->prefix . $this->field->field_slug . '" type="text"  id="' . $this->prefix . $this->field->field_slug . '" name="' . $this->prefix . $this->field->field_slug . '" size="' . $size . '" maxlength="200" value="' . $this->field->pre_selected_value . '"></label>';
    }

    private function create_select()
    {

        $html = '<select ' . $this->nsc_bar_is_disabled($this->field) . '  id="ff_' . $this->prefix . $this->field->field_slug . '"  name="' . $this->prefix . $this->field->field_slug . '" id="' . $this->prefix . $this->field->field_slug . '">';
        foreach ($this->field->selectable_values as $selectable_value) {
            $select = "";
            if ($selectable_value->value == $this->field->pre_selected_value) {$select = "selected";}
            $html .= '<option value="' . $selectable_value->value . '" ' . $select . '>' . $selectable_value->name . '</option>';
        }
        $html .= "</select>";
        return '<label>' . $html . '</label>';
    }

    private function create_radio()
    {
        $html = "";
        foreach ($this->field->selectable_values as $selectable_value) {
            $select = "";
            if ($selectable_value->value == $this->field->pre_selected_value) {$select = "checked";}
            $html .= '<input ' . $this->nsc_bar_is_disabled($this->field) . ' id="ff_' . $this->prefix . $this->field->field_slug . '"  type="radio" name="' . $this->prefix . $this->field->field_slug . '" value="' . $selectable_value->value . '" ' . $select . ' > ' . $selectable_value->name . ' ';
        }
        return '<label>' . $html . '</label>';
    }

    private function convert_to_string($input)
    {
        if (!is_string($input)) {
            return json_encode($input);
        }
        return $input;
    }

    private function nsc_bar_is_disabled($field)
    {
        if (class_exists("nsc_bara_html_formfields_addon") !== true) {
            return "";
        }

        $form_fields_addon = new nsc_bara_html_formfields_addon();
        return $form_fields_addon->nsc_bara_is_disabled($field);
    }

}
