using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantVacacionesanhio : BDconexion
    {
        public List<EMantenimiento> MantVacacionesanhio(Int32 anhio, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantVacacionesanhio oVMantVacacionesanhio = new CMantVacacionesanhio();
                    lCEMantenimiento = oVMantVacacionesanhio.MantVacacionesanhio(con, anhio, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}