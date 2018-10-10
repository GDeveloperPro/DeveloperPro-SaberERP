export class Er_contract_products {
  constructor(public er_contract_product_id: any,
              public er_contract_id_fk_contract_products: any,
              public er_contract_product_grade: any,
              public er_contract_product_state: any,
              public er_contract_product_active: any,
              public er_product_id_fk_er_contract: any,
              public er_contract_product_created_at: any) {
  }
}
