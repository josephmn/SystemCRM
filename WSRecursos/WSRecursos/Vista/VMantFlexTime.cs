using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantFlexTime : BDconexion
    {
        public List<EMantenimiento> MantFlexTime(
            Int32 post,
            Int32 id,
            String nombre,
            Int32 estado,
            String hinicio,
            String hfin,
            String htolerancia,
            Int32 zona,
            Int32 local,
            String user
            )
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantFlexTime oVMantFlexTime = new CMantFlexTime();
                    lCEMantenimiento = oVMantFlexTime.MantFlexTime(con, post, id, nombre, estado, hinicio, hfin, htolerancia, zona, local, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}