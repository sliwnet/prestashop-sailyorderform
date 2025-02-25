<?php
class SailyOrderFormFormModuleFrontController extends ModuleFrontController
{
    public function initContent()
    {
        parent::initContent();

        if (!Tools::getValue('ref') || !is_numeric(Tools::getValue('ref'))) {
            die('Nieprawidłowe zamówienie');
        }

        $id_order = (int)Tools::getValue('ref');
        $order = new Order($id_order);
        $customer = new Customer($order->id_customer);
        $address = new Address($order->id_address_invoice);

        $this->context->smarty->assign([
            'first_name' => $customer->firstname,
            'last_name' => $customer->lastname,
            'email' => $customer->email,
            'phone' => $address->phone,
            'birth_date' => '',
            'birth_place' => '',
            'street' => $address->address1,
            'house_number' => '',
            'postal_code' => $address->postcode,
            'city' => $address->city,
            'id_order' => $id_order
        ]);

        if (Tools::isSubmit('submit_form')) {
            Db::getInstance()->insert('saily_order_data', [
                'id_order' => $id_order,
                'first_name' => pSQL(Tools::getValue('first_name')),
                'last_name' => pSQL(Tools::getValue('last_name')),
                'email' => pSQL(Tools::getValue('email')),
                'phone' => pSQL(Tools::getValue('phone')),
                'birth_date' => pSQL(Tools::getValue('birth_date')),
                'birth_place' => pSQL(Tools::getValue('birth_place')),
                'street' => pSQL(Tools::getValue('street')),
                'house_number' => pSQL(Tools::getValue('house_number')),
                'postal_code' => pSQL(Tools::getValue('postal_code')),
                'city' => pSQL(Tools::getValue('city')),
                'can_swim' => (int)Tools::getValue('can_swim', 0),
                'data_agreement' => (int)Tools::getValue('data_agreement', 0)
            ]);
            Tools::redirect($this->context->link->getModuleLink('sailyorderform', 'form', ['ref' => $id_order, 'success' => 1]));
        }

        $this->setTemplate('module:sailyorderform/views/templates/front/form.tpl');
    }
}
