using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EPersonal
    {
        public string i_id { get; set; }
        public string v_dni { get; set; }
        public string v_nombres { get; set; }
        public string v_paterno { get; set; }
        public string v_materno { get; set; }
        public string v_correo { get; set; }
        public string v_area { get; set; }
        public string v_cargo { get; set; }
        public string d_fingreso { get; set; }
        public string i_estado { get; set; }
        public string id_zona { get; set; }
        public string v_zona { get; set; }
        public string id_local { get; set; }
        public string v_local { get; set; }
        public string id_area { get; set; }
        public string v_area_indicador { get; set; }
        public string id_cargo { get; set; }
        public string v_cargo_indicador { get; set; }
        public string i_turno { get; set; }
        public string v_turno { get; set; }
        public string i_flex { get; set; }
        public string v_flex { get; set; }
        public string i_remoto { get; set; }
        public string v_remoto { get; set; }
        public string i_marcacion { get; set; }
        public string v_marcacion { get; set; }
        public string i_venta { get; set; }
        public string v_venta { get; set; }
    }
}