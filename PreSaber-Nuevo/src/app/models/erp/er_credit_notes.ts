export class Er_credit_notes {
  constructor(public er_credit_note_id: any,
              public se_user_id_fk_credit_notes: any,
              public er_credit_note_type_fk_id__credit_note: any,
              public se_seller_id_fk_credit_notes: any,
              public er_credit_note_description: any,
              public er_credit_note_value: any,
              public er_credit_note_applied: any,
              public er_credit_note_state: any,
              public er_credit_note_active: any,
              public er_credit_note_id_fk_credit_note: any,
              public er_payment_id_fk_credit_note: any,
              public er_credit_note_created_at: any) {
  }
}
