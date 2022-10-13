using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantLogCTS : BDconexion
    {
        public List<EMantenimiento> MantLogCTS(String dni, String periodo, String ip)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantLogCTS oVMantLogCTS = new CMantLogCTS();
                    lCEMantenimiento = oVMantLogCTS.MantLogCTS(con, dni, periodo, ip);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}