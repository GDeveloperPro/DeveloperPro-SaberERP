export class Er_debit_notes {
  constructor(public er_debit_note_id: any,
              public se_user_id_fk_debit_notes: any,
              public er_debit_note_description: any,
              public er_debit_note_value: any,
              public er_debit_note_applied: any,
              public er_debit_note_paid: any,
              public er_debit_note_state: any,
              public er_debit_note_active: any,
              public er_debit_note_created_at: any,
              public se_seller_id_fk_debit_notes: any) {
  }
}
