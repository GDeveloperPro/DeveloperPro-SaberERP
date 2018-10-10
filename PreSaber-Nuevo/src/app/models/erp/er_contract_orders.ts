export class Er_contract_orders {
  constructor(public er_contract_order_id: any,
              public er_order_id_fk_contract_orders: any,
              public er_contract_id_fk_contract_orders: any,
              public se_user_id_fk_contract_orders: any,
              public er_contract_order_created_at: any,
              public er_contract_order_state: any,
              public er_contract_order_active: any,) {
  }
}
