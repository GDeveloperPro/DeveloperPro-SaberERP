export class Se_users{
  constructor(
    public se_user_id: any,
    public se_user_email: any,
    public se_user_password: any,
    public se_user_code: any,
    public se_user_last_connection: any,
    public se_user_created_at: any,
    public se_user_state_type: any,
    public se_user_state: any,
    public se_user_google_id: any,
    public se_user_twitter_id: any,
    public se_user_facebook_id: any,
    public se_role_id_fk_users: any,
    public se_group_id_fk_users: any
  ){}
}
