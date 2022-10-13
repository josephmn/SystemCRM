using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;

namespace WSRecursos.Entity
{
    public class EConsultaPerfil
    {
        public string v_dni { get; set; }
        public string v_nombre { get; set; }
        public string d_fnacimiento { get; set; }
        public string i_civil { get; set; }
        public string v_celular { get; set; }
        public string v_correo { get; set; }
        public string v_correo_empresa { get; set; }
        public string v_celular_sos { get; set; }
        public string v_nombre_sos { get; set; }
        public string v_departamento { get; set; }
        public string v_provincia { get; set; }
        public string v_distrito { get; set; }
        public string v_domicilio_actual { get; set; }
        public string v_referencia { get; set; }
    }
}