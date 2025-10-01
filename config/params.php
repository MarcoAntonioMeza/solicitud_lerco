<?php
return [
    //------------------------//
    // SYSTEM SETTINGS
    //------------------------//
    /**
     * Registration Needs Activation.
     *
     * If set to true, upon registration, users will have to activate their accounts using email account activation.
     */
    'rna' => true,

    /**
     * Login With [ Email => e, username => u, Email or username = > eu]
     *
     * If set to true, users will have to login using email/password combo.
     */
    'lw' => 'eu',

    /**
     * Force Strong Password.
     *
     * If set to true, users will have to use passwords with strength determined by StrengthValidator.
     */
    'fsp' => true,

    /**
     * Set the password reset token expiration time.
     */
    'user.passwordResetTokenExpire' => 3600,

    /**
     * Set the list of usernames that we do not want to allow to users to take upon registration or profile change.
     */
    'user.spamNames' => 'admin|superadmin|creator|thecreator|username',

    'bsVersion' => '4.x', // this will set globally `bsVersion` to Bootstrap 4.x for all Krajee Extensions

    //------------------------//
    // EMAILS
    //------------------------//
    /**
     * Email used in contact form.
     * Users will send you emails to this address.
     */
    'adminEmail' => 'huatulco.conecta@lercomx.com',
    

    /**
     * Email used in sign up form, when we are sending email with account activation link.
     * You will send emails to users from this address.
     */
    'supportEmail' => 'support@example.mx',

    //------------------------//
    // Settings Web Site
    //------------------------//
    'settings' => [
        'img-ico' => '@web/img/logo-white.png',
        'avg_interval' => 30000,
        'condusef_username'     => 'ejecutivo001',
        'condusef_password'     => 'EJ:001*2024',
        'condusef_token_access' => 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1aWQiOiJjMDI5ZmVhYi03MDZjLTRhZDktYTFlZi1jMmE5OGFmZGQxNjkiLCJ1c2VybmFtZSI6ImVqZWN1dGl2bzAwMSIsImluc3RpdHVjaW9uaWQiOiJCOTgxMzMxOC04RUEzLTRCMEYtQjM3Mi1EMTI1REU2NCIsImluc3RpdHVjaW9uQ2xhdmUiOjcyMzMsImRlbm9taW5hY2lvbl9zb2NpYWwiOiJBZ3JvbmVnb2Npb3MgTEFBRCwgUy5BLiBkZSBDLlYuLCBTT0ZPTSwgRS5OLlIuIiwic2VjdG9yaWQiOjI0LCJzZWN0b3IiOiJTT0NJRURBREVTIEZJTkFOQ0lFUkFTIERFIE9CSkVUTyBNVUxUSVBMRSBFTlIiLCJzeXN0ZW0iOiJSRURFQ08iLCJpYXQiOjE3MTM0NTE2MTUsImV4cCI6MTcxNjA0MzYxNX0.Zhg8nUsW4Y7-6d5b5SXYMGQTcP12qLfCdA-uJrN9NTc',
    ],

    //------------------------//
    // Grupos de Perfiles
    //------------------------//
    'auth_item_group' => [
        'admin'   => 'Administración',
        'cliente' => 'Clientes',
    ],


    //------------------------//
    // Listas desplegables
    //------------------------//
    'listas-desplegables' => require(__DIR__ . '/listas-desplegables.php'),


    /**
     * PARA ACTIVAR O DESACTIVAR EL MODE SOLO PARA PRODUCCION DE CONSULTAS
     */
    'is_productivo' => true,
    'url_cdc_dev'  => 'https://devcdc.lerco.agency/test/api/main.php',

    //'url_cdc_prod' => 'https://prodcdc.lerco.agency/test/api/main.php',
    'url_cdc_prod' => 'https://prodcdc.lerco.agency/main/main.php',
    //'url_cdc_prod' => 'http://localhost/dev-cdc-prod/main/main.php',

];
