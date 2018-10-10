export class Er_record_calendars {
  constructor(public er_record_calendar_id: any,
              public er_calendar_id_fk_record_calendar: any,
              public er_user_calendar_fk_record_calendar: any,
              public er_record_calendar_title: any,
              public er_record_calendar_start: any,
              public er_record_calendar_end: any,
              public er_record_calendar_primary_color: any,
              public er_record_calendar_secondary_color: any,
              public er_record_calendar_draggable: any,
              public er_record_calendar_beforeStart: any,
              public er_record_calendar_afterEnd: any,
              public er_record_calendar_state: any,
              public er_record_calendar_active: any,
              public er_record_calendar_created_at: any) {
  }
}
