export class Er_contracts {
  constructor(public er_contract_id: any,
              public se_user_id_fk_contracts: any,
              public se_seller_id_fk_contracts: any,
              public er_order_shipping_id_fk_contract: any,
              public er_order_type_id_fk_contract: any,
              public co_cities_id_fk_contract: any,
              public er_contract_file: any,
              public er_contract_created_at: any,
              public er_contract_active: any,
              public er_contract_state: any,) {
  }
}
