﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EControlRemoto
    {
        public Int32 i_id { get; set; }
        public string v_dni { get; set; }
        public string v_nombre { get; set; }
        public Int32 i_semana { get; set; }
        public string v_descripcion { get; set; }
        public Int32 i_mes { get; set; }
        public Int32 i_anhio { get; set; }
        public Int32 i_estado { get; set; }
        public string v_estado { get; set; }
        public string v_color { get; set; }
        public string SEMANA1 { get; set; }
        public string SEMANA2 { get; set; }
        public string SEMANA3 { get; set; }
        public string SEMANA4 { get; set; }
        public string SEMANA5 { get; set; }
        public string d_faprobacion { get; set; }
    }
}