<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class OrderDateCron extends Module
{
    public function __construct()
    {
        $this->name = 'orderdatecron';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Custom Dev';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = ['min' => '1.7', 'max' => _PS_VERSION_];
        $this->bootstrap = true;
        
        parent::__construct();
        
        $this->displayName = $this->l('Order Date Cron');
        $this->description = $this->l('Extracts date from product name and saves it in order details.');
    }

    public function install()
    {
        return parent::install() 
            && Configuration::updateValue('ORDERDATECRON_TOKEN', Tools::passwdGen(16))
            && $this->addNewColumn();
    }

    public function uninstall()
    {
        return parent::uninstall() 
            && Configuration::deleteByName('ORDERDATECRON_TOKEN');
    }

    private function addNewColumn()
    {
        $sql = "ALTER TABLE "._DB_PREFIX_ . "order_detail ADD COLUMN termin DATETIME NULL";
        try {
            return Db::getInstance()->execute($sql);
        } catch (Exception $e) {
            return false;
        }
    }

    public function getContent()
    {
        $output = '';
        
        if (Tools::isSubmit('submit_orderdatecron')) {
            $newToken = Tools::getValue('ORDERDATECRON_TOKEN');
            Configuration::updateValue('ORDERDATECRON_TOKEN', $newToken);
            $output .= $this->displayConfirmation($this->l('Token saved successfully.'));
        }

        $currentToken = Configuration::get('ORDERDATECRON_TOKEN');

        $output .= '<form action="" method="post">
            <label>' . $this->l('Security Token') . '</label>
            <input type="text" name="ORDERDATECRON_TOKEN" value="' . htmlspecialchars($currentToken) . '" required>
            <button type="submit" name="submit_orderdatecron" class="btn btn-primary">' . $this->l('Save') . '</button>
        </form>';

        return $output;
    }
}
