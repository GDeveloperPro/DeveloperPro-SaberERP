export class Er_pays{
  constructor(
    public er_pay_id:any,
    public er_credit_note_id_fk_pay:any,
    public er_debit_note_id_fk_pay:any,
    public er_payment_id_fk_pay:any,
    public er_purchase_id_fk_pay:any,
    public er_pay_pay:any,
    public er_pay_paid:any,
    public er_pay_created_at:any,
    public er_pay_state:any,
    public er_pay_active:any
  ){}
}
