using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VActualizacionDatos : BDconexion
    {
        public List<EMantenimiento> ActualizacionDatos(String dni)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CActualizacionDatos oVActualizacionDatos = new CActualizacionDatos();
                    lCEMantenimiento = oVActualizacionDatos.ActualizacionDatos(con, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}