
<script defer src="<?php echo base_url('js/file-upload.js') ?>"></script>
<link rel=stylesheet media=all href="<?php echo base_url('css/file-upload.css') ?>">


<?php
    function generate_html($name_to_upload, $class_name, $required = TRUE, $max_count = 1, $current_value = NULL)
    {
        $html = '
    <div class=file-uploader>
        <ul class=upload_preview>';

        // 显示当前图片
        if ( ! empty($current_value)):
            if (strpos($current_value, ',')):
                $urls = explode(',', $current_value);
            else:
                $urls[] = $current_value;
            endif;

            foreach($urls as $url):

                $html .=
                '<li data-input-name="'.$name_to_upload.'" data-item-url="'.$url.'">

                    <i class="adjuster remove far fa-minus"></i>
                    <i class="adjuster left far fa-arrow-left"></i>
                    <i class="adjuster right far fa-arrow-right"></i>
                    <figure>
                        <img src="'.$url.'">
                    </figure>
                </li>';

            endforeach;
        endif;

        // 当前值
        $current_value = !empty(set_value($name_to_upload))? set_value($name_to_upload): $current_value;

        $html .= '
        </ul>
        <div class=selector_zone>
            <input id='. $name_to_upload .' class=form-control type=file'.(($max_count > 1)? ' multiple': NULL).'>
            <input name='. $name_to_upload. ' type=hidden value="'. $current_value. '"'.(($required)? ' required': NULL).'>';

        $html .= '
            <div class=file_selector><i class="far fa-plus"></i></div>
        </div>
    
        <button class=file-upload type=button data-target-dir="'. $class_name.'/'.$name_to_upload. '" data-selector-id="'. $name_to_upload. '" data-input-name="'.$name_to_upload.'" data-max-count="'.$max_count.'">
            <i class="far fa-upload"></i> 上传
        </button>
    </div>';

        echo $html;
    } // end generate_html