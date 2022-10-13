using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantTablaFlexTime : BDconexion
    {
        public List<EMantenimiento> MantTablaFlexTime(
            Int32 post,
            Int32 id,
            Int32 semana,
            Int32 flex,
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
                    CMantTablaFlexTime oVMantTablaFlexTime = new CMantTablaFlexTime();
                    lCEMantenimiento = oVMantTablaFlexTime.MantTablaFlexTime(con, post, id, semana, flex, zona, local, user);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}