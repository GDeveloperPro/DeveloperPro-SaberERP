export class Se_profiles {
  constructor(public se_profile_id: any,
              public se_profile_identification: any,
              public se_profile_name: any,
              public se_profile_surname: any,
              public se_profile_image: any,
              public se_profile_birthdate: any,
              public se_profile_address: any,
              public se_profile_phone: any,
              public se_profile_phone_cell: any,
              public se_profile_state: any,
              public co_city_id_fk_profiles: any,
              public se_user_id_fk_profiles: any,
              public se_profile_active: any,
              public se_profile_created_at: any) {
  }
}
