export class Er_packaging_box_details{
  constructor(
    public er_packaging_box_detail_id:any,
    public er_packaging_box_id_fk_packaging_box_details:any,
    public er_packaging_box_detail_quantity:any,
    public er_packaging_box_detail_state:any,
    public er_packaging_box_detail_active:any,
    public er_packaging_box_detail_created_at:any,
    public er_order_detail_id_fk_packaging_box_details:any
  ){}
}
