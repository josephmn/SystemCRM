using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantLocal : BDconexion
    {
        public List<EMantenimiento> MantLocal(Int32 id, Int32 local, String nombre, Int32 zona, Int32 estado, String abrev, String user, String hinicio, String hfin, String htolerancia, Int32 tipoasistencia)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantLocal oVMantLocal = new CMantLocal();
                    lCEMantenimiento = oVMantLocal.MantLocal(con, id, local, nombre, zona, estado, abrev, user, hinicio, hfin, htolerancia, tipoasistencia);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}