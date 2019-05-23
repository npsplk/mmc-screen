js = jQuery.noConflict();

js(document).ready(function () {

        var user_detail = js('#user_name_data').val();
  
    if (user_detail.length == 4) {
        get_member_profile(user_detail);
        load_member_qualification_profile(user_detail);
    } else {
        get_personal_profile(user_detail);
        load_personal_qualification_profile(user_detail);
    }

});// end of document ready


function showWaitAlert(message, hide) {
    js(".form-alertbox").html(message);
    js(".form-alertbox").removeClass('alert-danger alert-success alert-info').addClass('alert-warning ');
    js(".form-alertbox").show();
    if (hide > 0) {
        setTimeout(function () {
            js(".form-alertbox").slideUp();
        }, 3000);
    }
}

function showSuccessAlert(message) {
//    close_btn = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    js(".form-alertbox").html(message);
    js(".form-alertbox").addClass("alert-dismissible");
    js(".form-alertbox").removeClass('alert-warning alert-danger alert-info').addClass('alert-success');
    js(".form-alertbox").show();
    setTimeout(function () {
        window.location.assign("user_dashboard");
    }, 2000);
}

function showFailedAlert(message) {
//    close_btn = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
    js(".form-alertbox").html(message);
    js(".form-alertbox").addClass("alert-dismissible");
    js(".form-alertbox").removeClass('alert-success alert-warning alert-info').addClass('alert-danger');
    js(".form-alertbox").show();
    setTimeout(function () {
        js(".form-alertbox").slideUp();
    }, 3000);
}



function get_personal_profile(user_detail) {
//    alert();
    var unknown = js('#unknown').val();
    js.post("user_profile_admin/load_personal_profile", {user_detail: user_detail}, function (e) {
        if (e === undefined || e.length === 0 || e === null || e.status == 2) {

            js("#user_img").attr("src", unknown);
            js('#my_name').html('User Details not found');
        } else {
//             console.log();
            js.each(e, function (index, qData) {
                if (!qData.FullName) {
                    js('#my_name_with_initials').html('No Data Found');
                } else {
                    js('#my_name_with_initials').html(qData.NameInitials + '.' + qData.FullName);
                }


                if (!qData.FullName) {
                    js('#my_name').html('No Data Found');
                } else {
                    js('#my_name').html(qData.Title + '.' + qData.FullName);
                }


                if (!qData.PermanentAddressLine1) {
                    js('#my_address').html('No Data Found');
                } else {
                    js('#my_address').html(qData.PermanentAddressLine1 + '<br>' + qData.PermanentAddressLine2 + '<br>' + qData.PermanentAddressLine3);
                }

                if (!qData.TelephoneHome && !qData.TelephoneMobile && !qData.TelephoneOffice) {
                    js('#my_telephone').html('No Data Found');
                } else {
                    js('#my_telephone').html('Home - &nbsp;' + qData.TelephoneHome + '<br>' + 'Mobile - &nbsp;' + qData.TelephoneMobile + '<br>' + 'Office - &nbsp;' + qData.TelephoneOffice);
                }


                if (!qData.bdate) {
                    js('#my_birthday').html('No Data Found');
                } else {
                    js('#my_birthday').html(qData.bdate);
                }



                if (!qData.Gender) {
                    js('#my_gender').html('No Data Found');
                } else {
                    js('#my_gender').html(qData.Gender == 1 ? "Male" : "Female");
                }


                if (!qData.EmailAddress) {
                    js('#my_email').html('No Data Found');
                } else {
                    js('#my_email').html(qData.EmailAddress);
                }


                if (!qData.ICASLNo) {
                    js('#ical_no').html('No Data Found');
                } else {
                    js('#ical_no').html(qData.ICASLNo);
                }


                if (!qData.PermanentAddressCity) {
                    js('#my_city').html('No Data Found');
                } else {
                    js('#my_city').html(qData.PermanentAddressCity);
                }


                if (!qData.CivilStatus) {
                    js('#my_civil_stat').html('No Data Found');
                } else {
                    js('#my_civil_stat').html(qData.CivilStatus);
                }


                if (!qData.NIC) {
                    js('#my_nic').html('No Data Found');
                } else {
                    js('#my_nic').html(qData.NIC);
                }


                if (!qData.LanguageMedium) {
                    js('#my_preferd_medium').html('No Data Found');
                } else {
                    js('#my_preferd_medium').html(qData.LanguageMedium);
                }




                if (!qData.PassportNo) {
                    js('#my_passport').html('No Data Found');
                } else {
                    js('#my_passport').html(qData.PassportNo);
                }


                if (!qData.Nationality) {
                    js('#my_nationality').html('No Data Found');
                } else {
                    js('#my_nationality').html(qData.Nationality);
                }


                if (!qData.PresentEmployment) {
                    js('#PresentEmployment').html('No Data Found');
                } else {
                    js('#PresentEmployment').html(qData.PresentEmployment);
                }



                if (!qData.TelephoneOffice) {
                    js('#telephone_office').html('No Data Found');
                } else {
                    js('#telephone_office').html(qData.TelephoneOffice);
                }



                if (!qData.ditrict) {
                    js('#my_district').html('No Data Found');
                } else {
                    js('#my_district').html(qData.ditrict);
                }


                if (!qData.Province) {
                    js('#my_province').html('No Data Found');
                } else {
                    js('#my_province').html(qData.Province);
                }


                if (!qData.AddressOfPlaceOfWorkLine1) {
                    js('#my_office_address').html('No Data Found');
                } else {
                    js('#my_office_address').html(qData.AddressOfPlaceOfWorkLine1 + '<br>' + qData.AddressOfPlaceOfWorkLine2 + '<br>' + qData.AddressOfPlaceOfWorkLine3);
                }

//                var maelurl = js('#male_url').val();
//                var femaelurl = js('#femaleurl').val();
                if (qData.Gender == 1) {
                    js("#user_img").attr("src", unknown);
                } else {
                    js("#user_img").attr("src", unknown);
                }
            });
        }
    }, "json");
}


function get_member_profile(user_detail) {
//    alert();
    var unknown = js('#unknown').val();
    js.post("user_profile_admin/load_member_profile", {user_detail: user_detail}, function (e) {
        if (e === undefined || e.length === 0 || e === null || e.status == 2) {

            js("#user_img").attr("src", unknown);
            js('#my_name').html('User Details are not sync with the system');
        } else {
//             
            js.each(e, function (index, qData) {
//                console.log(qData);
                if (!qData.FullName) {
                    js('#my_name_with_initials').html('No Data Found');
                } else {
                    js('#my_name_with_initials').html(qData.NameInitials + '.' + qData.FullName);
                }


                if (!qData.FullName) {
                    js('#my_name').html('No Data Found');
                } else {
                    js('#my_name').html(qData.Title + '.' + qData.FullName);
                }


                if (!qData.PermanentAddressLine1) {
                    js('#my_address').html('No Data Found');
                } else {
                    js('#my_address').html(qData.PermanentAddressLine1 + '<br>' + qData.PermanentAddressLine2 + '<br>' + qData.PermanentAddressLine3);
                }


                if (!qData.TelephoneHome && !qData.TelephoneMobile && !qData.TelephoneOffice) {
                    js('#my_telephone').html('No Data Found');
                } else {
                    js('#my_telephone').html('Home - &nbsp;' + qData.TelephoneHome + '<br>' + 'Mobile - &nbsp;' + qData.TelephoneMobile + '<br>' + 'Office - &nbsp;' + qData.TelephoneOffice);
                }

                if (!qData.bdate) {
                    js('#my_birthday').html('No Data Found');
                } else {
                    js('#my_birthday').html(qData.bdate);
                }

                if (!qData.Gender) {
                    js('#my_gender').html('No Data Found');
                } else {
                    js('#my_gender').html(qData.Gender == 1 ? "Male" : "Female");
                }


                if (!qData.EmailAddress) {
                    js('#my_email').html('No Data Found');
                } else {
                    js('#my_email').html(qData.EmailAddress);
                }


                if (!qData.ICASLNo) {
                    js('#ical_no').html('No Data Found');
                } else {
                    js('#ical_no').html(qData.ICASLNo);
                }


                if (!qData.PermanentAddressCity) {
                    js('#my_city').html('No Data Found');
                } else {
                    js('#my_city').html(qData.PermanentAddressCity);
                }


                if (!qData.CivilStatus) {
                    js('#my_civil_stat').html('No Data Found');
                } else {
                    js('#my_civil_stat').html(qData.CivilStatus);
                }


                if (!qData.NIC) {
                    js('#my_nic').html('No Data Found');
                } else {
                    js('#my_nic').html(qData.NIC);
                }


                if (!qData.LanguageMedium) {
                    js('#my_preferd_medium').html('No Data Found');
                } else {
                    js('#my_preferd_medium').html(qData.LanguageMedium);
                }

                if (!qData.PassportNo) {
                    js('#my_passport').html('No Data Found');
                } else {
                    js('#my_passport').html(qData.PassportNo);
                }

                if (!qData.Nationality) {
                    js('#my_nationality').html('No Data Found');
                } else {
                    js('#my_nationality').html(qData.Nationality);
                }


                if (!qData.PresentEmployment) {
                    js('#PresentEmployment').html('No Data Found');
                } else {
                    js('#PresentEmployment').html(qData.PresentEmployment);
                }


                if (!qData.TelephoneOffice) {
                    js('#telephone_office').html('No Data Found');
                } else {
                    js('#telephone_office').html(qData.TelephoneOffice);
                }


                if (!qData.ditrict) {
                    js('#my_district').html('No Data Found');
                } else {
                    js('#my_district').html(qData.ditrict);
                }


                if (!qData.Province) {
                    js('#my_province').html('No Data Found');
                } else {
                    js('#my_province').html(qData.Province);
                }


                if (!qData.AddressOfPlaceOfWorkLine1 && !qData.AddressOfPlaceOfWorkLine2 && !qData.AddressOfPlaceOfWorkLine3) {
                    js('#my_office_address').html('No Data Found');
                } else {
                    js('#my_office_address').html(qData.AddressOfPlaceOfWorkLine1 + '<br>' + qData.AddressOfPlaceOfWorkLine2 + '<br>' + qData.AddressOfPlaceOfWorkLine3);
                }

                var maelurl = js('#male_url').val();
                var femaelurl = js('#femaleurl').val();
                if (qData.Gender == 1) {
                    js("#user_img").attr("src", unknown);
                } else {
                    js("#user_img").attr("src", unknown);
                }

            });

        }
    }, "json");
}

function load_member_qualification_profile(user_detail) {
//    alert();
    var unknown = js('#unknown').val();
    js.post("user_profile_admin/load_member_qualification_profile", {user_detail: user_detail}, function (e) {
        if (e === undefined || e.length === 0 || e === null || e.status == 2) {

            js("#user_imgs").attr("src", unknown);
            js('#my_name').html('User Details are not sync with the system');
        } else {
//             console.log(e);
            js.each(e, function (index, qData) {


                js("#user_imgs").attr("src", unknown);
                if (!qData.acNameOfInstitution) {
                    js('#ac_name_of_institution').html('No Data Found');
                } else {
                    js('#ac_name_of_institution').html(qData.acInstitutionCode + '.' + qData.acNameOfInstitution);
                }
                if (!qData.acDuration) {
                    js('#ac_duration').html('No Data Found');
                } else {
                    js('#ac_duration').html(qData.acDuration);
                }
//                js('#ac_qualified_year').html(qData.QualifiedYear);
                if (!qData.Title) {
                    js('#ac_title').html('No Data Found');
                } else {
                    js('#ac_title').html(qData.Title);
                }

                if (!qData.genNameOfInstitution) {
                    js('#gen_institution').html('No Data Found');
                } else {
                    js('#gen_institution').html(qData.genInstitutionCode + '.' + qData.genNameOfInstitution);
                }
                if (!qData.genDuration) {
                    js('#gen_duration').html('No Data Found');
                } else {
                    js('#gen_duration').html(qData.genDuration);
                }
//                js('#gen_qulified_year').html(qData.QualifiedYear);
                if (!qData.IndexNo) {
                    js('#gen_index_number').html('No Data Found');
                } else {
                    js('#gen_index_number').html(qData.IndexNo);
                }
                if (!qData.MediumOfStudy) {
                    js('#gen_MediumOfStudy').html('No Data Found');
                } else {
                    js('#gen_MediumOfStudy').html(qData.MediumOfStudy);
                }
                if (!qData.proNameOfInstitution) {
                    js('#prof_NameOfInstitution').html('No Data Found');
                } else {
                    js('#prof_NameOfInstitution').html(qData.proNameOfInstitution);
                }

                if (!qData.Grade) {
                    js('#gen_grade').html('No Data Found');
                } else {
                    js('#gen_grade').html(qData.Grade);
                }
                if (!qData.QualificationName) {
                    js('#prof_QualificationName').html('No Data Found');
                } else {
                    js('#prof_QualificationName').html(qData.QualificationName);
                }
            });

        }
    }, "json");
}

function load_personal_qualification_profile(user_detail) {
//    alert();
    var unknown = js('#unknown').val();
    js.post("user_profile_admin/load_personal_qualification_profile", {user_detail: user_detail}, function (e) {
        if (e === undefined || e.length === 0 || e === null) {

            js("#user_imgs").attr("src", unknown);
            js('#my_name').html('User Details are not sync with the system');
        } else {
//             
            js.each(e, function (index, qData) {
//                console.log(qData.NameOfInstitution);

                js("#user_imgs").attr("src", unknown);
                if (!qData.acinstitute) {
                    js('#ac_name_of_institution').html('No Data Found');
                } else {
                    js('#ac_name_of_institution').html(qData.acinstitute);
                }
                if (!qData.ac_duration) {
                    js('#ac_duration').html('No Data Found');
                } else {
                    js('#ac_duration').html(qData.ac_duration);
                }
//                js('#ac_qualified_year').html(qData.QualifiedYear);
                if (!qData.Title) {
                    js('#ac_title').html('No Data Found');
                } else {
                    js('#ac_title').html(qData.Title);
                }

                if (!qData.geninstitute) {
                    js('#gen_institution').html('No Data Found');
                } else {
                    js('#gen_institution').html(qData.geninstitute);
                }
                if (!qData.gen_duration) {
                    js('#gen_duration').html('No Data Found');
                } else {
                    js('#gen_duration').html(qData.gen_duration);
                }
//                js('#gen_qulified_year').html(qData.QualifiedYear);
                if (!qData.IndexNo) {
                    js('#gen_index_number').html('No Data Found');
                } else {
                    js('#gen_index_number').html(qData.IndexNo);
                }
                if (!qData.MediumOfStudy) {
                    js('#gen_MediumOfStudy').html('No Data Found');
                } else {
                    js('#gen_MediumOfStudy').html(qData.MediumOfStudy);
                }
                if (!qData.proinstitute) {
                    js('#prof_NameOfInstitution').html('No Data Found');
                } else {
                    js('#prof_NameOfInstitution').html(qData.proinstitute);
                }

                if (!qData.Grade) {
                    js('#gen_grade').html('No Data Found');
                } else {
                    js('#gen_grade').html(qData.Grade);
                }
                if (!qData.QualificationName) {
                    js('#prof_QualificationName').html('No Data Found');
                } else {
                    js('#prof_QualificationName').html(qData.QualificationName);
                }

            });

        }
    }, "json");
}

//js.validator.addMethod("is_valid_nic", function (value, element) {
//    var nic = false;
//    nic = /^\d{9}[V|v|x|X]$/.test(value) || /^\d{12}$/.test(value);
//    return this.optional(element) || nic;
//}, "Invalid NIC");

//js.validator.addMethod("is_valid_name", function (value, element) {
//    var matched = false;
//    matched = /^[a-zA-Z\. ]*$/.test(value);
//    return this.optional(element) || matched;
//}, "Enter a valid name");

//js.validator.addMethod("is_valid_phone", function (value, element) {
//    var matched = false;
//    matched = /^[0-9]{2,3}[\-]?[0-9]{7}$/.test(value);
//    return this.optional(element) || matched;
//}, "Enter a valid phone number");


