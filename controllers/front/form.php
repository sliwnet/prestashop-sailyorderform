<?php
class SailyOrderFormFormModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        if (!Tools::getValue('ref')) {
            die('Nieprawidłowe zamówienie');
        }

        $reference = pSQL(Tools::getValue('ref'));
        $id_order = Db::getInstance()->getValue('SELECT id_order FROM ' . _DB_PREFIX_ . 'orders WHERE reference = "' . $reference . '"');
        
        if (!$id_order) {
            die('Zamówienie nie istnieje');
        }

        $order = new Order($id_order);
        $customer = new Customer($order->id_customer);
        $address = new Address($order->id_address_invoice);
        $quantity = Db::getInstance()->getValue('SELECT product_quantity FROM ' . _DB_PREFIX_ . 'order_detail WHERE id_order = ' . (int)$id_order);
        
        if (Tools::isSubmit('submit_form')) {
            foreach (Tools::getValue('participants') as $participant) {
                Db::getInstance()->insert('saily_order_data', [
                    'id_order' => $id_order,
                    'first_name' => pSQL($participant['first_name']),
                    'last_name' => pSQL($participant['last_name']),
                    'email' => pSQL($participant['email']),
                    'phone' => pSQL($participant['phone']),
                    'birth_date' => pSQL($participant['birth_date']),
                    'birth_place' => pSQL($participant['birth_place']),
                    'street' => pSQL($participant['street']),
                    'house_number' => pSQL($participant['house_number']),
                    'postal_code' => pSQL($participant['postal_code']),
                    'city' => pSQL($participant['city']),
                    'can_swim' => isset($participant['can_swim']) ? 1 : 0,
                    'data_agreement' => isset(Tools::getValue('data_agreement')) ? 1 : 0,
                ]);
            }
            Tools::redirect($this->context->link->getModuleLink('sailyorderform', 'form', ['ref' => $reference, 'success' => 1]));
        }

        $this->context->smarty->assign([
            'id_order' => $id_order,
            'participants' => []
        ]);

        $this->setTemplate('module:sailyorderform/views/templates/front/form.tpl');
    }
}
