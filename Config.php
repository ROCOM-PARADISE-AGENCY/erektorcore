<?php
/**
 * Created by Alex Negoita
 * IDE: PHP Storm
 * Date: 6/19/2019
 * Time: 7:58 PM
 * PHP Version 7
 */

namespace rpa\erektorcore;

class Config
{
    /*
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;


    /*
     * Should be changed foreach project
     *
     * @recommend use https://randomkeygen.com/ ->CodeIgniter Encryption Keys 256-bit key requirement
     *
     * Secret key for hashing
     * @var boolean
     */
    const SECRET_KEY = 'uri9EvTVEgL47HlJpj59P3wy3kZGx95b';



    /*
    * The Webmaster email is the one that receives emails from contact form for example
    *
    * @var string
    */
    const WEBMASTER_EMAIL = 'alexnegoita88@yahoo.com';




    /*
    * The Administrator email is the one that tracks the delivery of emails from contact form for example
    *
    * @var string
    */
    const ADMINISTRATOR_EMAIL = 'alex@paradise-agency.ro';



    /*
     * Specify main and backup SMTP servers
     */
    const EMAIL_HOST = 'mail.paradise-agency.ro';

    /*
     * SMTP username
     */
    const EMAIL_USERNAME = 'no-reply@paradise-agency.ro';

    /*
     * SMTP password
     */
    const EMAIL_PASSWORD = 'Kg9BRjn]nl,6';


    /*
    * Enable SMTP authentication
    */
    const SMTP_AUTH = true;

    /*
     * Enable TLS encryption, `ssl` also accepted
     */
    const SMTP_SECURE = 'tls';

    /*
     * Enable TLS encryption, `ssl` also accepted
     */
    const SMTP_PORT = '587'; //


    /*
     * Set a title for the website
     */
    const WEBSITE_TITLE = 'Erektor';


}