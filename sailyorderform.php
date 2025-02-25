<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class SailyOrderForm extends Module
{
    public function __construct()
    {
        $this->name = 'sailyorderform';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Saily.pl';
        $this->need_instance = 0;
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Saily Order Form');
        $this->description = $this->l('Formularz do zbierania dodatkowych danych dotyczących kursów.');
    }

    public function install()
    {
        return parent::install() && $this->registerHook('displayOrderConfirmation') && $this->installDatabase() && $this->installEmailTemplates();
    }

    public function uninstall()
    {
        return parent::uninstall() && $this->uninstallDatabase();
    }

    private function installDatabase()
    {
        return Db::getInstance()->execute('CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'saily_order_data` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `id_order` INT NOT NULL,
            `first_name` VARCHAR(255) NOT NULL,
            `last_name` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL,
            `phone` VARCHAR(20) NOT NULL,
            `birth_date` DATE NOT NULL,
            `birth_place` VARCHAR(255) NOT NULL,
            `street` VARCHAR(255) NOT NULL,
            `house_number` VARCHAR(50) NOT NULL,
            `postal_code` VARCHAR(20) NOT NULL,
            `city` VARCHAR(255) NOT NULL,
            `can_swim` TINYINT(1) NOT NULL,
            `data_agreement` TINYINT(1) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=' . _MYSQL_ENGINE_ . ' DEFAULT CHARSET=utf8;');
    }

    private function uninstallDatabase()
    {
        return Db::getInstance()->execute('DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'saily_order_data`;');
    }

    private function installEmailTemplates()
    {
        $mailDir = _PS_MODULE_DIR_ . $this->name . '/mails/en/';
        if (!file_exists($mailDir)) {
            mkdir($mailDir, 0755, true);
        }

        file_put_contents($mailDir . 'saily_order_confirmation.txt', "Dziękujemy {first_name} za uzupełnienie danych.");
        file_put_contents($mailDir . 'saily_order_confirmation.html', "<p>Dziękujemy {first_name} za uzupełnienie danych.</p>");
        
        return true;
    }

    public function getContent()
    {
        return '<h2>' . $this->displayName . '</h2><p>Moduł do zbierania dodatkowych danych zamówień kursów.</p>';
    }

    public function sendConfirmationEmail($email, $firstName)
    {
        $templateVars = [
            '{first_name}' => $firstName,
        ];
        
        return Mail::Send(
            (int)Configuration::get('PS_LANG_DEFAULT'),
            'saily_order_confirmation',
            $this->l('Dziękujemy za uzupełnienie danych'),
            $templateVars,
            $email,
            null,
            Configuration::get('PS_SHOP_EMAIL'),
            Configuration::get('PS_SHOP_NAME'),
            null,
            null,
            _PS_MODULE_DIR_ . $this->name . '/mails/'
        );
    }
}
