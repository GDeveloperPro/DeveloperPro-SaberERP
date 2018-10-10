export class Er_packaging_orders {
  constructor(public er_packaging_order_id: any,
              public er_packaging_id_fk_packaging_orders: any,
              public er_order_id_fk_packaging_orders: any,
              public er_packaging_order_state: any,
              public er_packaging_order_active: any,
              public er_packaging_order_created_at: any) {
  }
}
