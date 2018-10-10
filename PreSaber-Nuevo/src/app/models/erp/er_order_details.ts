export class Er_order_details {
  constructor(public er_order_detail_id: any,
              public er_order_id_fk_order_details: any,
              public er_product_id_fk_order_details: any,
              public er_order_detail_description: any,
              public er_order_detail_observation: any,
              public er_order_detail_state: any,
              public er_order_detail_active: any,
              public er_order_detail_quantity: any,
              public er_order_detail_created_at: any) {
  }
}
