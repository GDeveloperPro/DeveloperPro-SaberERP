export class Er_payments {
  constructor(public er_payment_id: any,
              public er_payment_type_id_fk_payments: any,
              public se_user_id_fk_payments: any,
              public se_seller_id_fk_payments: any,
              public er_payment_description: any,
              public er_payment_value: any,
              public er_payment_state: any,
              public er_payment_active: any,
              public er_payment_created_at: any) {
  }
}
