using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantIndicadorPersonal : BDconexion
    {
        public List<EMantenimiento> MantIndicadorPersonal(
            String dni, Int32 zona, Int32 local, Int32 area, Int32 cargo, Int32 turno, Int32 flex, Int32 remoto, Int32 marcacion, Int32 venta, String user)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantIndicadorPersonal oVMantIndicadorPersonal = new CMantIndicadorPersonal();
                    lCEMantenimiento = oVMantIndicadorPersonal.MantIndicadorPersonal(con, dni, zona, local, area, cargo, turno, flex, remoto, marcacion, venta, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}