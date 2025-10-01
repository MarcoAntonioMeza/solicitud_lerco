<?php

namespace app\components;

use Yii;
use yii\base\Component;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use yii\swiftmailer\Message;

class MailerHelper extends Component
{
    /**
     * Envía un correo con QR en el cuerpo.
     *
     * @param string $email  Correo del destinatario
     * @param string $nombre Nombre de la persona
     * @param string|int $id Identificador que se convertirá en QR
     */
    public static function sendQrMail(string $email, string $nombre, $id)
    {
        try {
            // Ruta temporal para guardar el QR
            $qrTemp = Yii::getAlias('@runtime') . "/qr_" . $id . ".png";

            // Generar QR
            $result = Builder::create()
                ->writer(new PngWriter())
                ->data((string)$id)
                ->size(200)
                ->margin(10)
                ->build();
            $result->saveToFile($qrTemp);

            // Crear mensaje
            /** @var Message $message */
            $message = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom(Yii::$app->params['adminEmail'])
                ->setSubject("Confirmación de Registro - Huatulco Conecta");

            // Embeder QR y obtener el cid
            $qrCid = $message->embed($qrTemp);

            // Contenido HTML del correo (ya con el cid real)
            $htmlContent = "
            <div style='font-family: Arial, sans-serif; background-color: #f4f4f4; padding:20px;'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0' 
                       style='max-width:600px; margin:auto; background:#ffffff; border-radius:8px; overflow:hidden;'>
                    <tr>
                        <td align='center' style='background:#00582c; padding:15px; color:#fff;'>
                            <h2 style='margin:0;'>Huatulco Conecta</h2>
                            <p style='margin:0; font-size:14px;'>Encuentro de Negocios y Financiamientos Productivos</p>
                        </td>
                    </tr>
                    <tr>
                        <td style='padding:20px;'>
                            <p>Hola <strong>{$nombre}</strong>,</p>
                            <p>Gracias por tu registro al evento <strong>Huatulco Conecta</strong>.</p>
                            
                            <p>Conserva este correo y presenta el siguiente código QR en el acceso:</p>
                            <p style='text-align:center;'>
                                <img src='{$qrCid}' alt='QR de acceso' style='max-width:200px;'>
                            </p>
                            <hr style='border:none; border-top:1px solid #ddd; margin:20px 0;'>
                            <p style='font-size:14px;'>
                                📍 <b>Sede:</b> Centro de Convenciones Hotel Las Brisas Huatulco, Oaxaca <br>
                                📅 <b>Fecha:</b> Viernes 10 de octubre de 2025 <br>
                                ⏰ <b>Horario:</b> 10:00 - 17:00 hrs
                            </p>
                            <p style='font-size:14px; color:#444;'>
                                Para más información puedes comunicarte al <b>+52 220 301 9857</b> 
                                o escribir a <b>huatulcoconecta@gmail.com</b>.
                            </p>
                            <p style='font-size:13px; color:#666; text-align:center; margin-top:30px;'>
                                Este correo fue generado automáticamente, por favor no respondas directamente.
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            ";

            // Setear el body ya con el QR inline
            $message->setHtmlBody($htmlContent);

            // Enviar
            $sent = $message->send();

            // Eliminar QR temporal
            if (file_exists($qrTemp)) {
                unlink($qrTemp);
            }

            return $sent;
        } catch (\Exception $e) {
            Yii::error("Error enviando correo: " . $e->getMessage(), __METHOD__);
            return "Error enviando correo: " . $e->getMessage();
        }
    }
}
