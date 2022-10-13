using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantVacacioncumpleanios : BDconexion
    {
        public List<EMantenimiento> MantVacacioncumpleanios(
            Int32 post,
            Int32 id,
            String fecha,
            String user
            )
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantVacacioncumpleanios oVMantVacacioncumpleanios = new CMantVacacioncumpleanios();
                    lCEMantenimiento = oVMantVacacioncumpleanios.MantVacacioncumpleanios(con, post, id, fecha, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}