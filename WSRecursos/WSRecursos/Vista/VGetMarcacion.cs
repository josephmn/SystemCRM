using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VGetMarcacion : BDconexion
    {
        public List<EMantenimiento> GetMarcacion(String dni)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CGetMarcacion oVGetMarcacion = new CGetMarcacion();
                    lCEMantenimiento = oVGetMarcacion.GetMarcacion(con, dni);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}