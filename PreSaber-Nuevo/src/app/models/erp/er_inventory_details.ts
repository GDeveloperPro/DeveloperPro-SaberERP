export class Er_inventory_details {
  constructor(public er_inventory_detail_id: any,
              public er_inventory_id_fk_inventory_details: any,
              public er_product_id_fk_inventory_details: any,
              public er_inventories_type_id_fk_inventory_details: any,
              public er_inventory_detail_description: any,
              public er_inventory_detail_quantity: any,
              public er_inventory_detail_created_at: any,
              public er_inventory_detail_state: any,
              public er_inventory_detail_active: any,
              public er_inventory_detail_quantity_real: any) {
  }
}
