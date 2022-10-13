using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantZona : BDconexion
    {
        public List<EMantenimiento> MantZona(Int32 id, Int32 zona, String nombre, Int32 estado, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantZona oVMantZona = new CMantZona();
                    lCEMantenimiento = oVMantZona.MantZona(con, id, zona, nombre, estado, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}