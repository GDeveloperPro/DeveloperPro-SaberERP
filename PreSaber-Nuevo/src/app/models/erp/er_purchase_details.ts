export class Er_purchase_details {
  constructor(public er_purchase_detail_id: any,
              public er_purchase_id_fk_purchase_details: any,
              public er_order_details_id_fk_puchase_details: any,
              public er_purchase_detail_comision: any,
              public er_purchase_detail_porcentage: any,
              public er_purchase_detail_state: any,
              public er_purchase_detail_active: any,
              public er_purchase_detail_created_at: any,
              public er_purchase_detail_price: any) {
  }
}
