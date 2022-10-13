using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantMeses : BDconexion
    {
        public List<EMantenimiento> MantMeses(Int32 id, Int32 estado, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantMeses oVMantMeses = new CMantMeses();
                    lCEMantenimiento = oVMantMeses.MantMeses(con, id, estado, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}