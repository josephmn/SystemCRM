using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarenviovacaciones : BDconexion
    {
        public List<EListarenviovacaciones> Listarenviovacaciones(Int32 mes, Int32 anhio)
        {
            List<EListarenviovacaciones> lCListarenviovacaciones = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarenviovacaciones oVListarenviovacaciones = new CListarenviovacaciones();
                    lCListarenviovacaciones = oVListarenviovacaciones.Listarenviovacaciones(con, mes, anhio);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarenviovacaciones);
        }
    }
}