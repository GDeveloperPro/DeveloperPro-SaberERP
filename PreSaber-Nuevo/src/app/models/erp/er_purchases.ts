export class Er_purchases{
  constructor(
    public er_purchase_id:any,
    public er_order_id_fk_purchases:any,
    public er_purchase_description:any,
    public er_purchase_value:any,
    public er_purchase_applied:any,
    public er_purchase_paid:any,
    public er_purchase_state:any,
    public er_purchase_active:any,
    public er_purchase_created_at:any
  ){}
}
