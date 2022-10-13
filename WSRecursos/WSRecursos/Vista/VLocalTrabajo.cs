using System;
using System.Collections.Generic;
using System.Data.SqlClient;
using System.Linq;
using System.Web;
using WSRecursos.Controller;
using WSRecursos.Entity;

namespace WSRecursos.view
{
    public class VLocalTrabajo : BDconexion
    {
        public List<ELocalTrabajo> LocalTrabajo()
        {
            List<ELocalTrabajo> lCLocalTrabajo = null;
            using (SqlConnection con = new SqlConnection(conexion))
            {
                try
                {
                    con.Open();
                    CLocalTrabajo oVLocalTrabajo = new CLocalTrabajo();
                    lCLocalTrabajo = oVLocalTrabajo.Listar_LocalTrabajo(con);
                }
                catch (SqlException)
                {
                    
                }
            }
                return (lCLocalTrabajo);
        }
    }
}