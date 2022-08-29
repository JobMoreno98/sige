function loader(flag) {
    if (flag) {
        
        return $(".loader").addClass("loader-activo");
        
    } else {
        
        return $(".loader").removeClass("loader-activo");

    }   
}