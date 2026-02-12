<?php
  $response = "";
/*
    include_once (get_template_directory().'/inc/securimage/securimage.php');
    $securimage = new Securimage();
*/

//function to generate response
function custom_contact_form($type, $message){

    global $response;


    if($type == "success") $response = "<div class='message message-success'>{$message}</div>";
      else $response = "<div class='message message-error'>{$message}</div>";
    }

    //response messages
    $not_human       = "Código inválido. Intente nuevamente";
    $missing_content = "Por favor provea toda la información necesaria";
    $email_invalid   = "Direccion de email no válida";
    $phone_invalid   = "El Teléfono no es correcto";
    $message_unsent  = "El mensaje no ha sido enviado, intente nuevamente";
    $message_sent    = "Gracias! el mensaje ha sido enviado correctamente";

    //user posted variables
    $submit         = $_POST['submitted'];
    $name           = $_POST['message_name'];
    $email          = $_POST['message_email'];
    $empresa        = $_POST['message_enterprise'];
    $cuit           = $_POST['message_cuit'];
    $message        = $_POST['message_text'];
    $phone          = $_POST['message_phone'];
    $contactTime    = $_POST['message_contactTime'];
    $human          = $_POST['message_human'];
    $date           = date('j/n/Y - H:i:s');
    $correct        = 5;
    $ip             = $_SERVER['REMOTE_ADDR'];


//php mailer variables
$options = get_option('site_options');
    if($options['email']){
        $to = $options['email'];
    }else{
        $to = get_option('admin_email');
    }

$subject = $name ." envió un mensaje desde ".get_bloginfo('name');
$headers = "From: ". $email . "\r\n" .
"Reply-To: " . $email . "\r\n";


  $product = '';
  if(is_single()){
    $product = 'Producto: ' . get_the_title() . "\r\n";
  }

    if ($submit){
        if (!$human){
        //validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
                //email is invalid
                    custom_contact_form("error", $email_invalid);
                } else {
                //validate presence of name and message
                    if (empty($name) || empty($message) || empty($phone)) {
                        custom_contact_form("error", $missing_content);
                    } else  {
                    //ready to go!
                          $sendMessage = $product
                          . "Nombre:  "              . $name        . "\r\n"
                          . "Email:   "              . $email       . "\r\n"
                          . "Empresa: "              . $enterprise  . "\r\n"
                          . "CUIT: "                 . $cuit        . "\r\n"
                          . "Teléfono / Celular: "   . $phone       . "\r\n"
                          . "Horario de contacto: "  . $contactTime . "\r\n"
                          . "Mensaje: "              . $message     . "\r\n"
                          . "------------------------------------"  . "\r\n"
                          . "IP: "                   . $ip          . "\r\n"
                          . "Fecha: "                . $date;

                          $sent = wp_mail($to, $subject, strip_tags($sendMessage), $headers);

                      if($sent) custom_contact_form("success", $message_sent); //message sent!
                      else custom_contact_form("error", $message_unsent); //message wasn't sent

                    }
                }
        } elseif ($_POST['submitted']) {
            custom_contact_form("error", $missing_content);
        }
    }
?>
<div id="respond">
    <?php echo $response; ?>
    <?php //$securimage_show = get_bloginfo('template_url').'/inc/securimage/securimage_show.php' ?>
    <form class="form form-horizontal form-fit" action="<?php the_permalink(); ?>" method="post">
        <div class="input">
            <label for="name">Nombre: <span>*</span></label>
            <input type="text" name="message_name" value="<?php echo esc_attr($_POST['message_name']); ?>" required />
        </div>
        <div class="input">
            <label for="message_email">Email: <span>*</span></label>
            <input type="text" name="message_email" value="<?php echo esc_attr($_POST['message_email']); ?>" required />
        </div>
        <div class="input">
            <label for="name">Empresa: </label>
            <input type="text" name="message_enterprise" value="<?php echo esc_attr($_POST['message_enterprise']); ?>" />
        </div>
        <div class="input">
            <label for="name">CUIT: </label>
            <input type="text" name="message_cuit" value="<?php echo esc_attr($_POST['message_cuit']); ?>" />
        </div>
        <div class="input">
            <label for="name">Teléfono: <span>*</span></label>
            <input type="text" name="message_phone" value="<?php echo esc_attr($_POST['message_phone']); ?>"  required />
        </div>
        <div class="input">
            <label for="name">Horario de contacto: </label>
            <input type="text" name="message_contactTime" value="<?php echo esc_attr($_POST['message_contactTime']); ?>" />
        </div>
        <div class="input">
            <label for="message_text">Mensaje: <span>*</span></label>
            <textarea type="text" name="message_text"  required ><?php echo esc_textarea($_POST['message_text']); ?></textarea>
        </div>
        <div class="input-align">
          <em><strong>*</strong> Campos obligatorios</em>
        </div>
        <?php /*
        <div class="input-align">
          <ul class="flush">
            <li>
              <img id="captcha" src="<?php echo $securimage_show ?>" alt="CAPTCHA Image" />
            </li>
            <li>
              <a href="#" class="btn" title="Recargar esta imagen" onclick="document.getElementById('captcha').src = '<?php echo $securimage_show ?>?' + Math.random(); return false">
                <i class="icon icons-ui icon-reload"></i>
              </a>
            </li>
          </ul>
          <ul class="flush">
            <li>
              <input placeholder="Ingrese el codigo de la imagen" type="text" name="captcha_code" size="32" maxlength="6"   />
            </li>
          </ul>
        </div>
        <div class="input">
            <label for="message_human">Human Verification: <span>*</span></label>
            <input type="text" style="width: 60px;" name="message_human"/> + 3 = 5
        </div>
        */ ?>
        <?php /*
        <div class="input">
            <label for="message_human">Código de verificación: <span>*</span></label>
            2 + 3 = <input type="text" style="width: 60px;" name="message_human"/>
        </div>
         */ ?>
        <div class="input none">
            <label for="message_human">Verificacion (dejar en blanco):</label>
            <input type="text" name="message_human" value="<?php echo esc_attr($_POST['message_human']); ?>" />
        </div>
        <input type="hidden" name="submitted" value="1">
        <br />
        <div class="submit">
            <button class="btn btn-primary" type="submit">Enviar &raquo;</button>
        </div>
    </form>
</div>
