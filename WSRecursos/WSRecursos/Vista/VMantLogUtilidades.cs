using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VMantLogUtilidades : BDconexion
    {
        public List<EMantenimiento> MantLogUtilidades(String dni, String periodo, String ip)
        {
            List<EMantenimiento> lCEMantenimiento = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CMantLogUtilidades oVMantLogUtilidades = new CMantLogUtilidades();
                    lCEMantenimiento = oVMantLogUtilidades.MantLogUtilidades(con, dni, periodo, ip);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCEMantenimiento);
        }
    }
}