export class Er_inventories {
  constructor(public er_inventory_id: any,
              public er_inventory_category_id_fk_inventories: any,
              public er_inventory_description: any,
              public er_inventory_state: any,
              public er_inventory_active: any,
              public er_inventory_created_at: any,
              public se_user_id_fk_inventorie: any) {
  }
}
