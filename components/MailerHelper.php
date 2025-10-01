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

            // Contenido HTML del correo estilo documento profesional
            $htmlContent = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { font-family: 'Arial', sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
                    .document { max-width: 650px; margin: 0 auto; background: white; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
                    .header { text-align: center; padding: 30px 20px 20px; background: linear-gradient(135deg, #629f46, #87c55a); }
                    .logo-section { background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; display: inline-block; }
                    .logo-text { color: #e91e63; font-size: 48px; font-weight: bold; margin: 0; line-height: 1; }
                    .conecta { color: #629f46; font-size: 48px; font-weight: bold; margin: 0; line-height: 1; }
                    .subtitle { color: #666; font-size: 16px; margin: 10px 0 0 0; }
                    .content { padding: 40px; }
                    .welcome { text-align: center; font-size: 32px; font-weight: bold; color: #333; margin-bottom: 30px; letter-spacing: 2px; }
                    .message { font-size: 16px; line-height: 1.6; color: #333; margin-bottom: 25px; }
                    .registration-info { background: #f8f9fa; padding: 25px; border-radius: 8px; text-align: center; margin: 30px 0; }
                    .id-text { font-size: 18px; color: #333; margin-bottom: 15px; }
                    .qr-container { margin: 20px 0; }
                    .example-section { background: #fff3e0; padding: 20px; border-radius: 8px; border-left: 4px solid #ff9800; margin: 25px 0; }
                    .example-title { color: #e65100; font-weight: bold; font-size: 16px; margin-bottom: 10px; }
                    .example-id { color: #d32f2f; font-size: 18px; font-weight: bold; margin: 10px 0; }
                    .footer-message { font-size: 16px; color: #333; text-align: center; margin-top: 30px; font-style: italic; }
                    .watermark { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); 
                                font-size: 120px; color: rgba(98, 159, 70, 0.05); font-weight: bold; z-index: 0; 
                                pointer-events: none; white-space: nowrap; }
                </style>
            </head>
            <body>
                <div class='document'>
                    <div style='position: relative; overflow: hidden;'>
                        <div class='watermark'>HUATULCO CONECTA</div>
                        
                        <div class='header'>
                            <div class='logo-section'>
                                <div style='display: flex; align-items: center; justify-content: center; gap: 15px;'>
                                    <div style='width: 80px; height: 80px; background: linear-gradient(135deg, #629f46, #87c55a); border-radius: 50%; display: flex; align-items: center; justify-content: center;'>
                                        <div style='color: white; font-size: 24px; font-weight: bold;'>🌊</div>
                                    </div>
                                    <div>
                                        <div class='logo-text'>Huatulco</div>
                                        <div class='conecta'>Conecta.</div>
                                    </div>
                                </div>
                                <div class='subtitle'>Encuentro de Negocios y<br>Financiamientos Productivos</div>
                            </div>
                        </div>

                        <div class='content' style='position: relative; z-index: 1;'>
                            <div class='welcome'>¡BIENVENIDO(A)!</div>
                            
                            <div class='message'>
                                Estimado(a) <strong>{$nombre}</strong>, agradecemos tu interés y participación en el 
                                <strong>Encuentro de Negocios y Financiamientos Productivos \"Huatulco Conecta\"</strong>
                            </div>
                            
                            <div class='message'>
                                A continuación, te proporcionamos tu Id y el QR que deberás presentar en 
                                la mesa de registro que estará disponible el día del evento:
                            </div>

                            <div class='registration-info'>
                                <div class='id-text'>Id Registro: <strong style='color: #629f46;'>{$id}</strong></div>
                                
                                
                                <div class='qr-container'>
                                    <img src='{$qrCid}' alt='QR de acceso' style='max-width: 200px; border: 3px solid #629f46; border-radius: 10px;'>
                                </div>
                            </div>

                            

                            <div class='message'>
                                Te recomendamos imprimir el presente comprobante de registro y 
                                presentarlo a tu llegada para agilizar el acceso al evento.
                            </div>

                            <div class='footer-message'>
                                <strong>¡Te Esperamos!</strong>
                            </div>

                            <div style='margin-top: 40px; padding: 20px; background: #f8f9fa; border-radius: 8px; font-size: 14px; color: #666;'>
                                <p><strong>📍 Sede:</strong> Centro de Convenciones Hotel Las Brisas Huatulco, Oaxaca</p>
                                <p><strong>📅 Fecha:</strong> Viernes 10 de octubre de 2025</p>
                                <p><strong>⏰ Horario:</strong> 10:00 - 17:00 hrs</p>
                                <p style='margin-top: 15px;'>
                                    Para más información: <strong>+52 220 301 9857</strong> | 
                                    <strong>huatulcoconecta@gmail.com</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </body>
            </html>
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
