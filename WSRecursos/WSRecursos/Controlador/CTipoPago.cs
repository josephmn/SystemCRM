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
    public class CTipoPago
    {
        public List<ETipoPago> Listar_TipoPago(SqlConnection con)
        {
            List<ETipoPago> lETipoPago = null;
            SqlCommand cmd = new SqlCommand("ASP_CONSULTAR_TIPOPAGO", con);
            cmd.CommandType = CommandType.StoredProcedure;
            SqlDataReader drd = cmd.ExecuteReader(CommandBehavior.SingleResult);

            if (drd != null)
            {
                lETipoPago = new List<ETipoPago>();

                ETipoPago obETipoPago = null;
                while (drd.Read())
                {
                    obETipoPago = new ETipoPago();
                    obETipoPago.i_id = drd["i_id"].ToString();
                    obETipoPago.v_descripcion = drd["v_descripcion"].ToString();
                    obETipoPago.v_default = drd["v_default"].ToString();
                    lETipoPago.Add(obETipoPago);
                }
                drd.Close();
            }

            return (lETipoPago);
        }
    }
}