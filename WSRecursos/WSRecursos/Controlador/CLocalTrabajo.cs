using System;
using System.Collections.Generic;
using System.Collections.ObjectModel;
using System.Collections.Specialized;
using System.Linq;
using System.Web;
using System.Data;
using System.Data.SqlClient;
using WSRecursos.Entity;

namespace WSRecursos.Controller
{
    public class CLocalTrabajo
    {
        public List<ELocalTrabajo> Listar_LocalTrabajo(SqlConnection con)
        {
            List<ELocalTrabajo> lELocalTrabajo = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_LOCALTRABAJO", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lELocalTrabajo = new List<ELocalTrabajo>();

                ELocalTrabajo obELocalTrabajo = null;
                while (drd.Read())
                {
                    obELocalTrabajo = new ELocalTrabajo();
                    obELocalTrabajo.i_id = drd["i_id"].ToString();
                    obELocalTrabajo.v_descripcion = drd["v_descripcion"].ToString();
                    obELocalTrabajo.v_default = drd["v_default"].ToString();
                    lELocalTrabajo.Add(obELocalTrabajo);
                }
                drd.Close();
            }

            return (lELocalTrabajo);
        }
    }
}