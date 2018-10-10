export class Er_user_calendars{
  constructor(
    public er_user_calendar_id:any,
    public er_calendar_id_fk_user_calendar:any,
    public er_user_calendar_state:any,
    public se_user_id_fk_user_calendar:any,
    public er_user_calendar_active:any,
    public er_user_calendar_created_at:any,
    public er_user_calendar_description:any
  ){}
}
