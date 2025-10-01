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
            
            // Embeder logo de Huatulco Conectaweb/img/image.png
            $logoPath = Yii::getAlias('@webroot') . '/img/image.png';
            #return $logoPath;
            $logoCid = $message->embed($logoPath);

            // Contenido HTML del correo estilo documento profesional
            $htmlContent = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body { 
                        font-family: 'Arial', sans-serif; 
                        margin: 0; 
                        padding: 20px; 
                        background: #f5f5f5; 
                        color: #333;
                    }
                    .document { 
                        max-width: 650px; 
                        margin: 0 auto; 
                        background: white; 
                        box-shadow: 0 0 20px rgba(0,0,0,0.1);
                        border: 1px solid #ddd;
                    }
                    .header { 
                        background: white; 
                        padding: 30px 20px; 
                        border-bottom: 2px solid #629f46;
                    }
                    .content { 
                        padding: 40px 50px; 
                        position: relative; 
                        z-index: 1; 
                    }
                    .welcome { 
                        text-align: center; 
                        font-size: 28px; 
                        font-weight: bold; 
                        color: #333; 
                        margin: 0 0 30px 0; 
                        letter-spacing: 3px;
                        text-transform: uppercase;
                    }
                    .message { 
                        font-size: 15px; 
                        line-height: 1.8; 
                        color: #333; 
                        margin-bottom: 25px; 
                        text-align: justify;
                    }
                    .registration-info { 
                        background: #f8f9fa; 
                        padding: 30px; 
                        border: 1px solid #e9ecef; 
                        text-align: center; 
                        margin: 30px 0; 
                    }
                    .id-text { 
                        font-size: 16px; 
                        color: #333; 
                        margin-bottom: 15px; 
                    }
                    .id-number {
                        color: #629f46;
                        font-weight: bold;
                        font-size: 18px;
                    }
                    .qr-container { 
                        margin: 20px 0; 
                        padding: 20px;
                        background: white;
                        border: 2px solid #629f46;
                        display: inline-block;
                    }
                    .example-section { 
                        background: #fff8e1; 
                        padding: 20px; 
                        border: 1px solid #ffcc02; 
                        margin: 25px 0; 
                        text-align: center;
                    }
                    .example-title { 
                        color: #ff6f00; 
                        font-weight: bold; 
                        font-size: 16px; 
                        margin-bottom: 10px; 
                    }
                    .example-id { 
                        color: #d32f2f; 
                        font-size: 18px; 
                        font-weight: bold; 
                        margin: 10px 0; 
                    }
                    .footer-message { 
                        font-size: 20px; 
                        color: #333; 
                        text-align: center; 
                        margin: 40px 0 30px 0; 
                        font-weight: bold;
                        letter-spacing: 2px;
                    }
                    .recommendation {
                        font-size: 15px;
                        color: #333;
                        text-align: center;
                        margin: 30px 0;
                        line-height: 1.6;
                    }
                    .watermark { 
                        position: absolute; 
                        top: 50%; 
                        left: 50%; 
                        transform: translate(-50%, -50%) rotate(-45deg); 
                        font-size: 100px; 
                        color: rgba(200, 200, 200, 0.1); 
                        font-weight: bold; 
                        z-index: 0; 
                        pointer-events: none; 
                        white-space: nowrap; 
                    }
                    .info-box {
                        background: #f8f9fa;
                        border: 1px solid #dee2e6;
                        padding: 20px;
                        margin: 30px 0;
                        font-size: 14px;
                        line-height: 1.6;
                    }
                </style>
            </head>
            <body>
                <div class='document'>
                    <div style='position: relative; overflow: hidden;'>
                        <div class='watermark'>HUATULCO CONECTA</div>
                        
                        <div class='header' style='background: white; padding: 30px 20px;'>
                            <div style='text-align: center;'>
                                <img src='{$logoCid}' alt='Huatulco Conecta' style='max-width: 400px; height: auto;'>
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
                                <div class='id-text'>Id Registro: <span class='id-number'>{$id}</span></div>
                                <div style='font-size: 14px; color: #666; margin: 15px 0;'>
                                    {imagen del QR personalizado generado por la plataforma}
                                </div>
                                
                                <div class='qr-container'>
                                    <img src='{$qrCid}' alt='QR de acceso' style='max-width: 180px; height: auto;'>
                                </div>
                            </div>


                            <div class='recommendation'>
                                Te recomendamos imprimir el presente comprobante de registro y 
                                presentarlo a tu llegada para agilizar el acceso al evento.
                            </div>

                            <div class='footer-message'>
                                ¡Te Esperamos!
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
