<?php

namespace app\utils\consultas;

use app\models\cliente\Persona;
use app\models\logs\LogApi;
class Gdc
{
    //private $createCustomerUrl = 'https://tekprovider.site/selfmanagementapi/api/Customer/CreatePersonCustomer?userId=3';
    //private $addressUrl = 'https://tekprovider.site/selfmanagementapi/api/address/GetStateCityAndSuburbsByZipcode';
    private $createCustomerUrl = "";
    private $cliente =  null;
    private $dataPost =  [];

    public function __construct($cliente_id)
    {
        $this->createCustomerUrl = 'https://dev.gestion-bds.lercomx.com/web/v1/originacion/post-solicitud';
        $this->cliente = $cliente_id;
    }

    #public function getLaborales()
    #{
    #    $cliente = Cliente::find()->select(['*'])
    #        ->where(['id' => $this->cliente])->one();
    #    $solicitud_id =  $cliente->solicituds[0]->id;
#
    #    $queryConfigIdentificacion = ConfigIdentificacion::getCuestionarioIdentificacionOne(Solicitud::getCuestionarioIdentificacionID($solicitud_id));
    #    foreach ($queryConfigIdentificacion["groups"] as $key_group => $item_group) {
    #        foreach ($item_group["items"] as $key_params => $item_params) {
#
    #            $queryConfigIdentificacion["groups"][$key_group]["items"][$key_params]["value_register"] = SolicitudIdentificacion::getValueItem($solicitud_id, $item_params["id"]);
    #        }
    #    }
#
    #    $laborales = $queryConfigIdentificacion['groups'][3]['items'];
    #    $cp = $laborales[2]['value_register'];
    #    try {
    #        $addres = $this->getAddressDataByZipcode($cp);
    #        return   [
    #            //"TaxAndDstatsueductions" => 0,
    #            "TypeId" => 1,
    #            //"EntranceDate" => 20220101,
    #            "EmployeeCode" => "NA",
    #            "Position" => "",
    #            "Income" => 10000,
    #            "EmployeeNumber" => "",
    #            "SuperiorPosition" => "NA",
    #            //"MonthsAt" => 11,
    #            //"SuperiorName" => "NA",
    #            //"YearsAt" => 6,
    #            //"VariableIncome" => 0,
    #            //"PaymentFrequencyId" => 1,
    #            //"MonthlyIncome" => 0,
    #            "Business" => [
    #                "LegalName" => $laborales[1]['value_register'],
    #                "CommercialName" => $laborales[1]['value_register'],
    #                "Address" => [
    #                    "Intersection" => "NA",
    #                    "CountryId"       => $addres['CountryId'],
    #                    "StateId"         => $addres['StateId'],
    #                    "CityId"          => $addres['CityId'],
    #                    "MunicipalityId"  => $addres['CityId'],
    #                    "Suburb" => $laborales[6]['value_register'],
#
    #                    //"TypeId" => 5,
    #                    "Municipality" => $laborales[8]['value_register'],
#
    #                    "FormattedLivingSince" => "08/11/1989",
    #                    "ZipCode" => $cp,
    #                    "InteriorNumber" => "",
#
    #                    "City" => $laborales[8]['value_register'],
#
#
    #                    "Street" => $laborales[3]['value_register'],
    #                    "StreetNumber" => $laborales[4]['value_register']
    #                ],
    #                "Telephones" => [
    #                    [
    #                        "Extension" => "0",
    #                        "TypeId" => 2,
    #                        "Number" => $laborales[9]['value_register'],
    #                        "ContactTime" => "Mañana"
    #                    ]
    #                ],
    #                //"ActivityId" => "19",
    #                "TaxId" => ""
    #            ]
    #        ];
    #    } catch (\Exception $e) {
    #        return null;
    #    }
#
    #    //print_r($queryConfigIdentificacion);
    #    //die;
    #    //
#
    #}
    /**
     * Procesa los datos del cliente, consulta información del CP y los envía al servicio para crear un cliente.
     *
     * @param array $data Los datos del cliente a enviar.
     * @return array La respuesta del servicio.
     */

    public function generateData()
    {

        $cliente_id = $this->cliente;

        $cliente = Persona::findOne($cliente_id);
        $fechaObjeto = \DateTime::createFromFormat('Y-m-d', $cliente->fecha_nacimiento);

        #$solicitud_id =  $cliente->solicituds[0]->id;
        #
        #
        #
        #$queryConfigIdentificacion = ConfigIdentificacion::getCuestionarioIdentificacionOne(Solicitud::getCuestionarioIdentificacionID($solicitud_id));
        #foreach ($queryConfigIdentificacion["groups"] as $key_group => $item_group) {
        #    foreach ($item_group["items"] as $key_params => $item_params) {
        #
        #        $queryConfigIdentificacion["groups"][$key_group]["items"][$key_params]["value_register"] = SolicitudIdentificacion::getValueItem($solicitud_id, $item_params["id"]);
        #    }
        #}
        #
        #print_r($queryConfigIdentificacion);
        #die;
        #RECIBE UN AJUSTE EL SCORE CDC PARA TP

        $companyId = 2; // APYMSA
        $score =  (int) $cliente->solicituds[0]->score;
        #if (
        #    $companyId === Validacion::AUTEX_PAY  #SOLO PARA APYMASA
        #    &&
        #    Validacion::RUTA_CDC == (int)$cliente->solicituds[0]->ruta  #SOLO RUTA CDC
        #    &&
        #    $score < 500 #SI ES UN SCORE MENOR A 500
        #) {
        #    $score = 500;  #SE CAMBIA EL SCORE A 500 para que pase el score CDC
        #}


        $branch_id = $cliente->solicituds ? $cliente->solicituds[0]->sucursal_id : null;


        #$conyuge = Conyuge::getDataForTeckConyuge($cliente->id);



        $this->dataPost = [
            //"BirthStateId" => $adress['CountryId'],
            "IdentificationNumber" => $cliente->rfc, // (($cliente->identificadorCiudadano == "125430041" || $cliente->identificadorCiudadano == "103744687") ? "1723848216" : $cliente->identificadorCiudadano),
            "Email" => $cliente->email,
            "Telephone" => $cliente->telefono,
            "FormattedBirthdate" =>$fechaObjeto->format('d/m/Y'),
            "Address" => [
                //"Intersection" => "NA",
                //"CountryId" => $adress['CountryId'],
                //"TypeId" => 1,
                "Municipality" => $cliente->dirs['municipio'],
                "Suburb" => $cliente->dirs['colonia'],
                // "FormattedLivingSince" => $fechaObjeto->format('d\\/m\\/Y'),
                "ZipCode" => $cliente->dirs['codigo_search'],
                "InteriorNumber" => $cliente->dirs['num_int'],
                "StateId" => $cliente->dirs['estado'],
                "State" => $cliente->dirs['estado'],
                "City" => $cliente->dirs['municipio'],
                "Street"       => $cliente->dirs['direccion'],
                "StreetNumber" => $cliente->dirs['num_ext'],
                //"MunicipalityId" => $cliente->dirs['ciudad_id'],
                //"CityId" => $cliente->dirs['ciudad_id'],
                //"PropertyTypeId" => "",
                //"Telephones" => [
                //    [
                //        "Extension" => "0",
                //        "TypeId" => 2,
                //        "Number" => "3331761211"
                //    ]
                //],

                //"StatusId" => 1
            ],
            "Customer" => [
                "RiskId" => $cliente->solicituds[0]->get_riesgo_number(), #         1 alto , 2 medio 3 bajo
                "Score" => $score,
                //"Code" => ""
            ],
            "CreditForm" => [
                "Score" => $score,
                "BranchId" => $branch_id,
                "CutOffDay" => $cliente->solicituds[0]->corte,
                "ScoreTypeId" => $cliente->solicituds[0]->get_tipo_score()
            ],
            "Emails" => [
                [
                    "TypeId" => 2,
                    "EmailAddress" => $cliente->email,
                ]
            ],
            /*"Job" => [
                "TaxAndDstatsu 
                eductions" => 0,
                "TypeId" => 1,
                "EntranceDate" => 20220101,
                "EmployeeCode" => "NA",
                "Position" => "",
                "Income" => 10000,
                "EmployeeNumber" => "NUMBEREJEMPLO",
                "SuperiorPosition" => "NA",
                "MonthsAt" => 11,
                "SuperiorName" => "NA",
                "YearsAt" => 6,
                "VariableIncome" => 0,
                "PaymentFrequencyId" => 1,
                "MonthlyIncome" => 0,
                "Business" => [
                    "LegalName" => "TRANSPORTES EUA",
                    "CommercialName" => "TRANSPORTES EUA",
                    "Address" => [
                        "Intersection" => "NA",
                        "CountryId" => 2,
                        "TypeId" => 5,
                        "Municipality" => "Guadalajara",
                        "Suburb" => "Huentitán El Alto",
                        "FormattedLivingSince" => "08/11/1989",
                        "ZipCode" => "44390",
                        "InteriorNumber" => "",
                        "StateId" => 73,
                        "City" => "Guadalajara",
                        "MunicipalityId" => 1308,
                        "CityId" => 1308,
                        "Street" => "ANTONIO LARRAÑAGA",
                        "StreetNumber" => "1124"
                    ],
                    "Telephones" => [
                        [
                            "Extension" => "0",
                            "TypeId" => 2,
                            "Number" => "3344556677",
                            "ContactTime" => "Mañana"
                        ]
                    ],
                    "ActivityId" => "19",
                    "TaxId" => ""
                ]
            ], */
            #"BirthCountryId" => $adress['CountryId'],
            //"MaritalStatusId" => "3",
            "CompanyId" => $companyId,

            #"Relations" => [
            #    [
            #        "FormattedKnowSince" => "08/11/1989",
            #        "TypeId" => 2,
            #        "AcreditedId" => null,
            #        "RelationType" => 0,
            #        "KnownSince" => null,
            #        'Person' => []#$conyuge['Person'][0],
            #        /*"Person" => [
            #            "Email" => "correo2sssssssss@ejemplo.com",
            #            "FirstName" => "Juan",
            #            "Telephones" => [
            #                [
            #                    "Extension" => "0",
            #                    "TypeId" => 2,
            #                    "Number" => "3331761211"
            #                ]
            #            ],
            #            "LastName" => "perez",
            #            "Emails" => [
            #                [
            #                    "TypeId" => 2,
            #                    "EmailAddress" => "ejemplo2sssssssss@correo.com"
            #                ]
            #            ],
            #            "MiddleName" => "",
            #            "SecondLastName" => "benitez"
            #        ]*/
            #    ]
            #],
            "FirstName" => $cliente->nombres,
            "MiddleName" => $cliente->segundo_nombre,
            "Mobile" =>  $cliente->telefono,
            "SecondLastName" => $cliente->apellido_materno,
            "CURP" => $cliente->curp,
            #"GenderId" => "",
            "Telephones" => [
                [
                    "TypeId" => 2,
                    "Number" => $cliente->telefono
                ]
            ],
            #"NationalityId" => 1,
            #"PersonComplements" => [
            #    "OcupationId" => "1"
            #],
            "LastName" => $cliente->apellido_paterno
        ];

        #$job = $this->getLaborales();
        #//return $job;
        #if ($job) {
        #    $this->dataPost['Job'] = $job;
        #}

        $this->dataPost['CreditForm']['MontoAutorizado'] = floatval($cliente->solicituds[0]->monto);
        $this->dataPost['token'] = 'Nj7p9YnRYKejih8tTr-40TIx7T2OnofU';



        return $this->dataPost;
    }

    public function processCustomer()
    {

        // Procesar los datos
        $processedData = $this->generateData();

        // Enviar la solicitud
        return $this->createCustomer($processedData);
    }




    /**
     * Envía una solicitud POST al servicio para crear un cliente.
     *
     * @param array $data Los datos del cliente a enviar.
     * @return array La respuesta del servicio.
     */
    private function createCustomer($data)
    {


        $ch = curl_init($this->createCustomerUrl);

        $solisitudInfo = json_encode($data);
        // Configuración de cURL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $solisitudInfo);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);



        // Especificar el archivo de certificados CA
        //curl_setopt($ch, CURLOPT_CAINFO, 'C:\xampp\cacert.pem'); // Asegúrate de usar la ruta correcta

        // Ejecutar solicitud
        $response = curl_exec($ch);

        // Verificar errores
        if (curl_errno($ch)) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new \Exception("cURL Error: $error");
        }

        // Cerrar cURL
        curl_close($ch);
        LogApi::save_log(LogApi::GDC,'GDC', $data, json_decode($response, true));

        #$cliente = Cliente::findOne($this->cliente);
        #LogApis::saveLog('Conexion con teck', $cliente->sucursal_id, $cliente->empresa_id, $solisitudInfo, $response, 'Solicitud Teck', 'TECK');
        // Decodificar respuesta
        return json_decode($response, true);
    }
}
