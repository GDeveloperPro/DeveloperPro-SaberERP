export class Au_order_users {
  constructor(public au_order_user_id: any,
              public er_order_id_fk_order_users: any,
              public se_user_id_fk_order_users: any,
              public er_process_detail_id_fk_order_users: any,
              public au_order_user_created_at: any,
              public au_order_user_active: any,
              public au_order_user_state: any) {
  }
}
