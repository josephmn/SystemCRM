using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VListarpagovacaciones : BDconexion
    {
        public List<EListarpagovacaciones> Listarpagovacaciones(Int32 post, Int32 mes, Int32 anhio, String fecha)
        {
            List<EListarpagovacaciones> lCListarpagovacaciones = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CListarpagovacaciones oVListarpagovacaciones = new CListarpagovacaciones();
                    lCListarpagovacaciones = oVListarpagovacaciones.Listarpagovacaciones(con, post, mes, anhio, fecha);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCListarpagovacaciones);
        }
    }
}