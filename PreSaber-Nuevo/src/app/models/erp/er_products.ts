export class Er_products{
  constructor(
    public er_product_id:any,
    public er_product_code:any,
    public er_product_name:any,
    public er_product_description:any,
    public er_product_image:any,
    public er_product_existence:any,
    public er_product_created_at:any,
    public er_product_state:any,
    public er_cellar_id_fk_products:any,
    public er_product_category_id_fk_products:any,
    public er_products_type_id_fk_products:any,
    public er_product_active:any,
    public er_product_session:any,
    public er_product_order_quantity:any
  ){}
}
